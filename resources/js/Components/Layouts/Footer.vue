<script setup lang="ts"></script>

<template>
    <footer class="footer py-4">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div
                        class="copyright text-muted text-lg-start text-center text-sm"
                    >
                        ©
                        {{ new Date().getFullYear() }}, crafted with
                        <i class="fa fa-heart"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul
                        class="nav nav-footer justify-content-center justify-content-lg-end"
                    >
                        <li class="nav-item">
                            <a
                                href="https://whatthefun.id"
                                class="nav-link text-muted"
                                target="_blank"
                                >Whatthefun.id</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</template>
