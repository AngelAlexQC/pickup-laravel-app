<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryChildremCategoriesDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public Category $category;
    public Category $category;
    public $categoryFile;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Category';

    protected $rules = [
        'category.name' => ['required', 'max:255', 'string'],
        'category.slug' => ['nullable', 'max:255', 'string'],
        'category.description' => ['nullable', 'max:255', 'string'],
        'category.meta' => ['nullable', 'max:255', 'string'],
        'categoryFile' => ['nullable', 'file'],
    ];

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->resetCategoryData();
    }

    public function resetCategoryData()
    {
        $this->category = new Category();

        $this->categoryFile = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCategory()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.category_childrem_categories.new_title'
        );
        $this->resetCategoryData();

        $this->showModal();
    }

    public function editCategory(Category $category)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.category_childrem_categories.edit_title'
        );
        $this->category = $category;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->category->parent_category_id) {
            $this->authorize('create', Category::class);

            $this->category->parent_category_id = $this->category->id;
        } else {
            $this->authorize('update', $this->category);
        }

        if ($this->categoryFile) {
            $this->category->file = $this->categoryFile->store('public');
        }

        $this->category->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Category::class);

        collect($this->selected)->each(function (string $id) {
            $category = Category::findOrFail($id);

            if ($category->file) {
                Storage::delete($category->file);
            }

            $category->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCategoryData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->category->categories as $category) {
            array_push($this->selected, $category->id);
        }
    }

    public function render()
    {
        return view('livewire.category-childrem-categories-detail', [
            'categories' => $this->category->categories()->paginate(20),
        ]);
    }
}
