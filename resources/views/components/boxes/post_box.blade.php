<script>
    function openModal(post_id) {
        [...document.querySelectorAll(".post-modal")].filter(modal => {
            modal.style.display = "none";
            let modal_id = modal.getAttribute("post-id");
            if (modal_id.toString() === post_id.toString()) {
                modal.style.display = "block"
            }
        })
        closeModal();
        document.body.classList.toggle("overflow-hidden")
    }

    function closeModal(post_id) {
        if (post_id) {
            let modal = document.querySelector(`.post-modal[post-id='${post_id}']`);
            modal.style.display = "none";
            document.body.classList.toggle("overflow-hidden")
            return
        }
        // if click to otside etc...
    }
</script>

<div class="app-rounded relative grid overflow-hidden bg-gray-600">
    <figure>
        <img class="w-full" src="{{ $post->src }}" alt="">
    </figure>
    <div class="mt-4 border-b border-gray-400 px-3 pb-4 text-gray-50">
        <div class="flex items-center justify-between">
            <div>
                <h6 class="font-semibold">{{ shortenText($post->caption, 50) }}</h6>
                <p class="mt-0.5 text-sm text-gray-200">
                    {{ shortenText($post->description) }}
                </p>
                @if (!$post->hide_likes)
                    <div class="mt-1.5">
                        {{-- when clicked below button open modal and show profiles that liked this post --}}
                        <button>
                            <i class="fa fa-heart text-sm"></i> {{ count($post->likedByUsers) }}
                        </button>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-x-4">
                <form action="">
                    <button type="submit" class="text-xl text-white">
                        <i class="fa-regular fa-bookmark"></i>
                    </button>
                </form>
                <form form_state="0" icon-fill action="{{ route('user.post.like', ['post_id' => $post->id]) }}"
                    method="POST">
                    @csrf
                    <button type="submit" class="text-xl text-white">
                        @if (isPostLikedByAuth($post->id))
                            <i class="fa fa-heart"></i>
                        @else
                            <i class="fa-regular fa-heart"></i>
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="min-h-24 px-3 pb-3">
        <div class="mt-4 flex items-center justify-between py-1 pr-4">
            <form action="">
                {{-- goes to spesific profile --}}
                <div class="flex items-center">
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $post->user->avatar_src }}"
                        alt="avatar" />
                    <span class="ml-2 font-normal text-white">{{ $post->user->nick_name }}</span>
                </div>
            </form>
            @if (isOwnerPost($post))
                <button onclick="openModal({{ $post->id }})"
                    class="hover_jump cursor-pointer text-white duration-200">
                    <form action="">
                        <i class="fa fa-pen"></i>
                    </form>
                </button>
            @endif
        </div>
    </div>
</div>

<div post-id="{{ $post->id }}" class="post-modal app-modal text-white">
    <div class="absolute right-4 top-2">
        <button onclick="closeModal({{ $post->id }})" class="text-xl">
            <i class="fa fa-xmark"></i>
        </button>
    </div>

    <form action="{{ route('post.update', ['post_id' => $post->id]) }}" method="POST" class="flex flex-col justify-between h-full"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-4">
            <input class="border-1 app-rounded border-gray-400 px-3 py-4" type="text" name="caption"
                placeholder="{{ $post->caption }}">
            <div class="flex items-center gap-x-4">
                <div>
                    <img class="h-24" src="{{ $post->src }}">
                </div>
                <input class="app-rounded bg-gray-600 px-3 py-4 text-white" type="file" name="src">
            </div>
            <textarea class="app-rounded px-4 py-2" name="description" placeholder="{{ $post->description }}"></textarea>
            <div class="mb-2 text-2xl font-semibold">Privacy</div>
            <div>
                <label class="flex items-center gap-x-3">
                    Post Hide Likes
                    <input @checked($post->hide_likes) class="cursor-pointer" name="hide_likes" type="checkbox">
                </label>
            </div>
        </div>
        <button type="submit"
            class="app-rounded mt-5 w-full bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
    </form>
    <form action="{{ route('post.destroy', ['post_id' => $post->id]) }}" method="POST" class="absolute right-4 bottom-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="app-rounded bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Delete Post</button>
    </form>
</div>
