<?php

declare(strict_types=1);

namespace App\Domains\Content\Requests;

use App\Domains\Content\Repositories\ContentCriteria;
use App\Domains\Content\Repositories\ContentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowSubcategoryRequest extends FormRequest
{
    public function getContentCriteria(): ContentCriteria
    {
        return ContentCriteria::from([
            ...$this->get('content', []),
            'subcategory' => $this->route('subcategory'),
        ]);
    }

    public function getContents(): Collection|LengthAwarePaginator
    {
        $contentRepo = new ContentRepository($this->getContentCriteria());
        $paginate = 'false' == $this->boolean('content.paginate');

        return $paginate
            ? $contentRepo->get()
            : $contentRepo->paginate($this->get('content', []));
    }
}
