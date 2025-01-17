<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="sidebar bg-light" style="width: 250px; height: 100vh; position: fixed;">
    <ul class="nav flex-column p-3">
        <li class="nav-item">
            <a class="nav-link active" href="/dashboard">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/profile">
                <i class="fas fa-user me-2"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/settings">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
        </li>
    </ul>
</div>