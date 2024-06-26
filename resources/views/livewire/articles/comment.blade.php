<div>
    <h5 class="mb-3">{{$total_comment}} Comments</h5>
    @auth
    <form wire:submit.prevent="store" class="mb-4">
        <div class="mb-3">
            <textarea wire:model.defer="body" rows="2" class="form-control @error('body')is-invalid @enderror"
                placeholder="Tulis komentar..."></textarea>
            @error('body')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    @endauth
    @guest
    <div class="alert alert-primary" role="alert">
        login dulu untuk komentar <a href="{{route('login')}}">login</a>
    </div>
    @endguest
    @foreach ($comments as $item)
    <div class="mb-3">
        <div class="d-flex align-items-start mb-3">
            <img class="img-fluid rounded-circle me-2" width="40"
                src="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/91/91a09746173fa3251cd6c1cce849d77d8444f816_full.jpg"
                alt="">
            <div>
                <div>
                    <span>{{$item->user->name}}</span>
                    <span>{{$item->created_at}}</span>
                </div>
                <div class="mb-2 text-secondary">
                    {{$item->body}}
                </div>
                <div>
                    @auth
                    <button class="btn btn-sm btn-primary" wire:click="selectReply({{$item->id}})">Balas</button>

                    @if ($item->user_id == Auth::user()->id)
                    <button class="btn btn-sm btn-warning" wire:click="selectEdit({{$item->id}})">Edit</button>
                    <button class="btn btn-sm btn-danger"
                        onclick="confirm('Are you sure remove this comment?') || event.stopImmediatePropagation()"
                        wire:click="delete({{$item->id}})">Hapus</button>
                    @endif
                    @if (isset($item->hasLike))
                    <button wire:click="like({{$item->id}})" class="btn btn-sm btn-danger">
                        <i class="bi bi-heart-fill me-2"></i>({{$item->totalLikes()}})
                    </button>
                    @else
                    <button wire:click="like({{$item->id}})" class="btn btn-sm btn-dark">
                        <i class="bi bi-heart-fill me-2"></i>({{$item->totalLikes()}})
                    </button>

                    @endif

                    @endauth
                </div>
                @if (isset($comment_id) && $comment_id == $item->id)
                <form wire:submit.prevent="reply" class="my-4">
                    <div class="mb-3">
                        <textarea wire:model.defer="body2" rows="2"
                            class="form-control @error('body2')is-invalid @enderror"
                            placeholder="Tulis komentar..."></textarea>
                        @error('body2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">reply</button>
                    </div>
                </form>
                @endif
                @if (isset($edit_comment_id) && $edit_comment_id == $item->id)
                <form wire:submit.prevent="change" class="my-4">
                    <div class="mb-3">
                        <textarea wire:model.defer="body2" rows="2"
                            class="form-control @error('body2')is-invalid @enderror"
                            placeholder="Tulis komentar..."></textarea>
                        @error('body2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @if ($item->childrens)
        @foreach ($item->childrens as $item2)
        <div class="d-flex align-items-start mb-3 ms-4">
            <img class="img-fluid rounded-circle me-2" width="40"
                src="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/91/91a09746173fa3251cd6c1cce849d77d8444f816_full.jpg"
                alt="">
            <div>
                <div>
                    <span>{{$item2->user->name}}</span>
                    <span>{{$item2->created_at}}</span>
                </div>
                <div class="mb-2 text-secondary">
                    {{$item2->body}}
                </div>
                <div>
                    @auth
                    <button class="btn btn-sm btn-primary" wire:click="selectReply({{$item2->id}})">Balas</button>
                    @if (isset($item2->hasLike))
                    <button wire:click="like({{$item2->id}})" class="btn btn-sm btn-danger">
                        <i class="bi bi-heart-fill me-2"></i>({{$item2->totalLikes()}})
                    </button>
                    @else
                    <button wire:click="like({{$item2->id}})" class="btn btn-sm btn-dark">
                        <i class="bi bi-heart-fill me-2"></i>({{$item2->totalLikes()}})
                    </button>

                    @endif
                    @if ($item2->user_id == Auth::user()->id)
                    <button class="btn btn-sm btn-warning" wire:click="selectEdit({{$item2->id}})">Edit</button>
                    <button class="btn btn-sm btn-danger"
                        onclick="confirm('Are you sure remove this comment?') || event.stopImmediatePropagation()"
                        wire:click="delete({{$item2->id}})">Hapus</button>

                    @endif

                    @endauth
                </div>
                @if (isset($comment_id) && $comment_id == $item2->id)
                <form wire:submit.prevent="reply" class="my-4">
                    <div class="mb-3">
                        <textarea wire:model.defer="body2" rows="2"
                            class="form-control @error('body2')is-invalid @enderror"
                            placeholder="Tulis komentar..."></textarea>
                        @error('body2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">Balas</button>
                    </div>
                </form>
                @endif
                @if (isset($edit_comment_id) && $edit_comment_id == $item2->id)
                <form wire:submit.prevent="change" class="my-4">
                    <div class="mb-3">
                        <textarea wire:model.defer="body2" rows="2"
                            class="form-control @error('body2')is-invalid @enderror"
                            placeholder="Tulis komentar..."></textarea>
                        @error('body2')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
                @endif
            </div>
        </div>

        @endforeach
        @endif
        {{-- <div class="d-flex align-items-start ms-5 mb-3">
            <img class="img-fluid rounded-circle me-2" width="40"
                src="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/91/91a09746173fa3251cd6c1cce849d77d8444f816_full.jpg"
                alt="">
            <div>

                <div>
                    <span>Hadi Purnomo</span>
                    <span>12 juli 2022</span>
                </div>
                <div class="text-secondary">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                </div>
                <div>
                    @auth

                    <button class="btn btn-sm btn-primary">Balas</button>
                    <button class="btn btn-sm btn-warning">Edit</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                    <button class="btn btn-sm btn-danger">
                        <i class="bi bi-heart-fill me-2"></i>(2)
                    </button>
                    @endauth
                </div>
            </div>


        </div> --}}

    </div>
    <hr>
    @endforeach

</div>
</div>
</div>