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

<div class="app-rounded post-box-{{ $post->id }} relative grid overflow-hidden bg-gray-600">
    <!-- Slider main container -->
    <div class="swiper-post relative">
        @if (count($post->images) > 1)
            <div class="opacity-55 absolute bottom-0 left-1/2 z-10 -translate-x-1/2 text-app-white">
                <i class="fa-solid fa-ellipsis"></i>
            </div>
        @endif
        @if (count($post->images) > 1)
            <div class="opacity-55 post-count absolute left-7 top-2 z-10 -translate-x-1/2 text-app-white duration-200">
                <div class="children bg-black px-4 py-2">{{ count($post->images) }}</div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const POST_BOX = document.querySelector(".post-box-{{ $post->id }}");
                    window.box = POST_BOX;
                    let allow_display_index = true;
                    POST_BOX.querySelector(".swiper-post").addEventListener("mouseenter", function() {
                        POST_BOX.querySelector(".post-count").style.left = "2.5rem"
                        setTimeout(() => {
                            POST_BOX.querySelector(".post-count").style.opacity = .75
                        }, 200);
                    })
                    POST_BOX.querySelector(".swiper-post").addEventListener("mouseleave", function() {
                        POST_BOX.querySelector(".post-count").style.left = ""
                        POST_BOX.querySelector(".post-count").classList.toggle("left-10")
                        setTimeout(() => {
                            POST_BOX.querySelector(".post-count").querySelector("*").innerText =
                                "{{ count($post->images) }}"
                        }, 100);
                        setTimeout(() => {
                            POST_BOX.querySelector(".post-count").style.opacity = .55
                        }, 200);
                    })

                })
            </script>
        @endif
        <div class="swiper-wrapper">
            @foreach ($post->images as $image)
                <div class="swiper-slide">
                    <figure>
                        <img class="aspect-video w-full object-cover" src="{{ $image->src }}">
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4 border-b border-gray-400 px-3 pb-4 text-gray-50">
        <div class="flex items-end justify-between">
            <div>
                <h6 class="font-semibold">{{ shortenText($post->caption, 50) }}</h6>
                <p class="mt-0.5 text-sm text-gray-200">
                    {{ shortenText($post->description) }}
                </p>
                @if (!$post->hide_likes || $post->user->id == $auth->id)
                    <div class="mt-1.5">
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
            <a class="flex-1" href="{{ route('profile.show', ['id' => $post->user->id]) }}">

                <div class="flex items-center">
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $post->user->avatar_src }}"
                        alt="avatar" />
                    <span class="ml-2 font-normal text-white">{{ $post->user->nick_name }}</span>
                </div>
            </a>
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

    <form action="{{ route('post.update', ['post_id' => $post->id]) }}" method="POST"
        class="flex h-full flex-col justify-between" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-4">
            <input class="border-1 app-rounded border-gray-400 px-3 py-4 text-app-black" type="text" name="caption"
                placeholder="{{ $post->caption }}">
            <div class="grid grid-cols-2 gap-y-4">
                @foreach ($post->images as $image)
                    <div class="flex">
                        <img class="w-24" src="{{ $image->src }}">
                        <input class="app-rounded bg-gray-600 px-3 py-4" type="file"
                            name="file_{{ $image->id }}">
                    </div>
                @endforeach
            </div>
            <textarea class="app-rounded px-4 py-2 text-app-black" name="description" placeholder="{{ $post->description }}"></textarea>
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
    <form disabled="true" post-id="{{ $post->id }}" action="{{ route('post.destroy', ['post_id' => $post->id]) }}"
        method="POST" class="absolute bottom-4 right-4">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="app-rounded bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Delete
            Post</button>
    </form>

</div>
<div class="bg-overlay spinner-wrapper fixed inset-0 z-50 hidden h-screen w-screen">
    <div class="spinner fixed left-1/2 top-1/2"></div>
</div>
