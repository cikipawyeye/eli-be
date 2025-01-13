<template>
    <div class="nav-wrapper position-relative end-0">
        <ul
            :class="`nav nav-pills nav-fill p-1 ${variant}`"
            ref="navPills"
            :style="{ border: border ? '1px solid #e5e5e5' : 'none' }"
        >
            <li
                class="nav-item"
                v-for="(item, index) in props.items"
                :key="index"
                @click="emit('click', item.id)"
            >
                <a
                    class="nav-link mb-0 px-0 py-1"
                    :class="{ active: item.active }"
                    data-bs-toggle="tab"
                    href="javascript:;"
                    role="tab"
                    :aria-controls="item.name"
                    :aria-selected="item.active ? true : false"
                >
                    {{ item.name }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue';

const emit = defineEmits<{
    click: [id: string];
}>();

const props = defineProps<{
    items: {
        id: string;
        name: string;
        active?: boolean;
    }[];
    variant?:
        | 'nav-pills-primary'
        | 'nav-pills-info'
        | 'nav-pills-success'
        | 'nav-pills-warning'
        | 'nav-pills-danger'
        | 'nav-pills-dark'
        | 'nav-pills-vertical';
    border?: boolean;
}>();

const navPills = ref<HTMLElement | null>(null);

const handleResize = () => {
    navPills.value?.querySelector('.moving-tab')?.remove();
    let movingDiv = document.createElement('div');
    let tab = navPills.value
        ?.querySelector('.nav-link.active')
        ?.cloneNode(true) as HTMLElement;
    tab.innerHTML = '-';
    movingDiv.classList.add('moving-tab', 'position-absolute', 'nav-link');
    movingDiv.appendChild(tab);
    navPills.value?.appendChild(movingDiv);

    movingDiv.style.padding = '0px';
    movingDiv.style.transition = '.5s ease';

    let li = navPills.value?.querySelector('.nav-link.active')?.parentElement;
    if (li) {
        let nodes = Array.from(li.closest('ul')?.children || []);
        let index = nodes.indexOf(li) + 1;
        let sum = 0;
        if (navPills.value?.classList.contains('flex-column')) {
            for (let j = 1; j <= nodes.indexOf(li); j++) {
                sum +=
                    navPills.value?.querySelector<HTMLElement>(
                        `li:nth-child(${j})`,
                    )?.offsetHeight ?? 0;
            }
            movingDiv.style.transform = `translate3d(0px,${sum}px, 0px)`;
            movingDiv.style.width =
                navPills.value?.querySelector<HTMLElement>(
                    `li:nth-child(${index})`,
                )?.offsetWidth + 'px';
            movingDiv.style.height =
                navPills.value?.querySelector<HTMLElement>(
                    `li:nth-child(${index})`,
                )?.offsetHeight + 'px';
        } else {
            for (let j = 1; j <= nodes.indexOf(li); j++) {
                sum +=
                    navPills.value?.querySelector<HTMLElement>(
                        `li:nth-child(${j})`,
                    )?.offsetWidth ?? 0;
            }
            movingDiv.style.transform = `translate3d(${sum}px, 0px, 0px)`;
            movingDiv.style.width =
                navPills.value?.querySelector<HTMLElement>(
                    `li:nth-child(${index})`,
                )?.offsetWidth + 'px';
        }
    }

    if (window.innerWidth < 991) {
        navPills.value?.classList.remove('flex-row');
        navPills.value?.classList.add('flex-column', 'on-resize');
    } else {
        navPills.value?.classList.remove('flex-column', 'on-resize');
        navPills.value?.classList.add('flex-row');
    }

    // Resize handling for small devices
    if (window.innerWidth < 991) {
        navPills.value?.classList.remove('flex-row');
        navPills.value?.classList.add('flex-column', 'on-resize');
    }
};

const initNavs = () => {
    if (!navPills.value) {
        return;
    }

    let movingDiv = document.createElement('div');
    let firstLi = navPills.value.querySelector('li:first-child .nav-link');
    let tab = firstLi?.cloneNode(true) as HTMLElement;
    tab.innerHTML = '-';

    movingDiv.classList.add('moving-tab', 'position-absolute', 'nav-link');
    movingDiv.appendChild(tab);
    navPills.value.appendChild(movingDiv);

    movingDiv.style.padding = '0px';
    movingDiv.style.width =
        navPills.value.querySelector<HTMLElement>('li:nth-child(1)')
            ?.offsetWidth + 'px';
    movingDiv.style.transform = 'translate3d(0px, 0px, 0px)';
    movingDiv.style.transition = '.5s ease';

    navPills.value.onmouseover = (event: MouseEvent) => {
        let target = event.target as HTMLElement;
        let li = target.closest('li'); // get reference
        if (li) {
            let nodes = Array.from(li.closest('ul')?.children || []);
            let index = nodes.indexOf(li) + 1;
            navPills
                .value!.querySelector(`li:nth-child(${index}) .nav-link`)
                ?.addEventListener('click', () => {
                    movingDiv =
                        navPills.value!.querySelector<HTMLDivElement>(
                            '.moving-tab',
                        )!;
                    let sum = 0;
                    if (navPills.value!.classList.contains('flex-column')) {
                        for (let j = 1; j <= nodes.indexOf(li); j++) {
                            sum +=
                                navPills.value!.querySelector<HTMLElement>(
                                    `li:nth-child(${j})`,
                                )?.offsetHeight || 0;
                        }
                        movingDiv.style.transform = `translate3d(0px,${sum}px, 0px)`;
                        movingDiv.style.height =
                            navPills.value!.querySelector<HTMLElement>(
                                `li:nth-child(${index})`,
                            )?.offsetHeight + 'px';
                    } else {
                        for (let j = 1; j <= nodes.indexOf(li); j++) {
                            sum +=
                                navPills.value!.querySelector<HTMLElement>(
                                    `li:nth-child(${j})`,
                                )?.offsetWidth || 0;
                        }
                        movingDiv.style.transform = `translate3d(${sum}px, 0px, 0px)`;
                        movingDiv.style.width =
                            navPills.value!.querySelector<HTMLElement>(
                                `li:nth-child(${index})`,
                            )?.offsetWidth + 'px';
                    }
                });
        }
    };

    // Resize event
    window.addEventListener('resize', handleResize);
};

onMounted(() => {
    initNavs();
});

onUnmounted(() => {
    window.removeEventListener('resize', () => {
        navPills.value?.querySelector('.moving-tab')?.remove();
    });
});
</script>
