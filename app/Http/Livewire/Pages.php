<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Pages extends Component
{
    public $modelFormVisible = false;
    public $title;
    public $slug;
    public $content;

    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required'
        ];
    }

    public function updatedTitle($value)
    {
        $this->generateSlug($value);
    }

    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
        $this->modelFormVisible = false;
        $this->resetVars();
    }
    /**
     * createShowModal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modelFormVisible = true;
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

    public function generateSlug($value)
    {
        $process1 = str_replace(' ', '-', $value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
    }

    public function render()
    {
        return view('livewire.pages');
    }
}
