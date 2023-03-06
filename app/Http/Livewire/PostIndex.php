<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PostIndex extends Component
{
    use WithFileUploads;

    public $showingPostModal = false;

    public $title;
    public $newImage;
    public $body;
    public $oldImage;
    public $isEditMode = false;
    public $post;

    public function showPostModal()
    {
        $this->reset();
        $this->showingPostModal = true;
    }

    public function storePost()
    {
        $this->validate([
            'title' => 'required',
            'newImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required',
        ]);

        $image = $this->newImage->store('posts', 'public');

        Post::create([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body,
        ]);
        $this->reset();
    }

    public function showEditPostModal($id)
    {
        $this->post = Post::findOrFail($id);
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->oldImage = $this->post->image;
        $this->isEditMode = true;
        $this->showingPostModal = true;
    }

    public function updatePost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $image = $this->post->image;
        if ($this->newImage) {
            $image = $this->newImage->store('posts', 'public');
        }

        $this->post->update([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body,
        ]);
        $this->reset();
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete($post->image);
        $post->delete();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.post-index', [
            'posts' => Post::all()
        ]);
    }
}
