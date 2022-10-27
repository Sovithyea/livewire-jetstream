<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;
    public $modelFormVisible = false;
    public $modalConfirmDelete = false;
    public $modelId;
    public $title;
    public $slug;
    public $content;

    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')->ignore($this->modelId)],
            'content' => 'required'
        ];
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function read()
    {
        return Page::paginate(5);
    }

    /**
     * createShowModal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetVars();
        $this->resetValidation();
        $this->modelFormVisible = true;
    }

    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
        $this->modelFormVisible = false;
        $this->resetVars();
    }

    public function updatedTitle($value)
    {
        $this->generateSlug($value);
    }

    public function generateSlug($value)
    {
        $process1 = str_replace(' ', '-', $value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
    }
    /**
     * updateShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modelFormVisible = true;
        $this->loadModel();
    }

    /**
     * loadModel
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }


    public function update()
    {
        $this->validate();
        Page::find($this->modelId)->update($this->modelData());
        $this->modelFormVisible = false;
        $this->modelId = null;
    }



    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDelete = true;
    }

    public function delete()
    {
        // dd($this->modelId);
        Page::destroy($this->modelId);
        $this->modalConfirmDelete = false;
        $this->resetPage();
        $this->modelId = null;
    }

    /**
     * modelData
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content
        ];
    }

    public function resetVars()
    {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }


    public function render()
    {
        return view('livewire.pages', [
            'data' => $this->read()
        ]);
    }
}
