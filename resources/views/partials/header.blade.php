<header class="masthead" style="background-image: url({{ $image }})">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                @if (isset($title_size) && $title_size === 'sm')
                    <div class="post-heading">
                @else
                    <div class="site-heading">
                @endif
                        <h1>{{ $title }}</h1>
                        @if (isset($subtitle))
                            @if (isset($title_size) && $title_size === 'sm')
                                <span class="meta">
                                    {{ $subtitle }}
                                </span>
                            @else
                                <span class="subheading">{{ $subtitle }}</span>
                            @endif
                        @endif
                </div>
            </div>
        </div>
    </div>
</header>
