<header class="bg-light">
    <nav class="navbar navbar-expand-md navbar-light container ">
        <!-- Logo -->

        <!-- Nav -->
        <ul class="navbar-nav ">
            <li class="nav-item <?php echo explode('/', $content)[0]=='home' ? 'active': "" ?>">
                <a class="nav-link " href="/">Home</a>
            </li>
            <li class="nav-item <?php echo explode('/', $content)[0]=='categories'? "active" : "" ?>">
                <a class="nav-link" href="/category">Category</a>
            </li>
        </ul>
        <a class="navbar-brand ml-auto" href="/">
            <img src="../../../public/images/logo.jpg" height="100" alt="Logo">
        </a>
    </nav>
</header>