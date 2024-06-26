<?php

namespace App\Livewire\Articles;


use App\Models\Article;
use App\Models\Comment as ModelsComment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Comment extends Component
{
    public $body, $body2, $article;
    public $comment_id, $edit_comment_id;

    public function mount($id)
    {
        $this->article = Article::find($id);
    }

    public function render()
    {
        return view('livewire.articles.comment', [
            // 'comments' => ModelsComment::with('user')->where('article_id', $this->article->id)->get(),
            'comments' => ModelsComment::with('user', 'childrens')
                ->where('article_id', $this->article->id)
                ->whereNull('comment_id')
                ->orderBy('created_at', 'desc')
                ->get(),
            'total_comment' => ModelsComment::where('article_id', $this->article->id)->count()
        ]);
    }

    public function store()
    {
        $this->validate(['body' => 'required']);
        $comment = ModelsComment::create([
            'user_id' => Auth::user()->id,
            'article_id' => $this->article->id,
            'body' => $this->body
        ]);

        if ($comment) {
            // scroll refresh ke komentar yang baru dibuat
            // $this->emit('comment_store', c $comment->id);
            // $this->dispatch('comment_store', commentId: $comment->id);
            $this->body = NULL;

            // session()->flash('success', 'komentar berhasil dibuat');
            // return redirect()->route('articles.show', $this->article->slug);
        } else {
            session()->flash('danger', 'komentar gagal dibuat');
            return redirect()->route('articles.show', $this->article->slug);
        }
    }

    public function selectEdit($id)
    {
        $comment = ModelsComment::find($id);
        $this->edit_comment_id = $comment->id;
        $this->body2 = $comment->body;
    }

    public function change()
    {
        $this->validate(['body2' => 'required']);
        $comment = ModelsComment::where('id', $this->edit_comment_id)->update(
            ['body' => $this->body2]
        );


        if ($comment) {
            $this->body = NULL;
            $this->edit_comment_id = NULL;
        } else {
            session()->flash('danger', 'komentar gagal diubah');
            return redirect()->route('articles.show', $this->article->slug);
        }
    }

    public function selectReply($id)
    {
        $this->comment_id = $id;
        $this->edit_comment_id = NULL;
        $this->body2 = NULL;
    }
    public function reply()
    {
        $this->validate(['body2' => 'required']);
        $comment = ModelsComment::find($this->comment_id);
        $comment = ModelsComment::create([
            'user_id' => Auth::user()->id,
            'article_id' => $this->article->id,
            'body' => $this->body2,
            'comment_id' => $comment->comment_id ? $comment->comment_id : $comment->id
        ]);

        if ($comment) {
            $this->body2 = NULL;
            $this->comment_id = NULL;
        } else {
            session()->flash('danger', 'komentar gagal dibalas');
            return redirect()->route('articles.show', $this->article->slug);
        }
    }



    public function delete($id)
    {

        $comment = ModelsComment::where('id', $id)->delete();
        if ($comment) {
            return NULL;
        } else {
            session()->flash('danger', 'komentar gagal dihapus.');
            return redirect()->route('articles.show', $this->article->slug);
        }
    }

    public function like($id)
    {
        $data = [
            'comment_id' => $id,
            'user_id' => Auth::user()->id
        ];

        $like = Like::where($data);
        if ($like->count() > 0) {
            $like->delete();
        } else {
            Like::create($data);
        }
        return NULL;
    }
}
