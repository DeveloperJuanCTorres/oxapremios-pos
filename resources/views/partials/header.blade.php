<header>
    <div class="d-flex align-items-center flex-grow-1 gap-4">
    </div>
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light rounded-circle p-2 text-secondary">
            <i class="fa-solid fa-bell"></i>
        </button>
        <button class="btn btn-light rounded-circle p-2 text-secondary">
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
        
        <div class="user-dropdown">

            <button
                class="user-profile-btn"
                type="button">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=004ac6&color=fff"
                    alt="{{ auth()->user()->name }}">

                <div class="user-info">

                    <span class="user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <small class="user-role">
                        Usuario activo
                    </small>

                </div>

                <i class="fa-solid fa-chevron-down"></i>

            </button>

        </div>
    </div>
</header>