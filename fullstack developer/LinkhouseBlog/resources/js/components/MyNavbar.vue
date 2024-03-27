<template>
    <nav class="navbar navbar-expand-md">
        <div class="container container-fluid">
            <img src="../../../public/logo.png" alt="logo" class="logo" />

            <Button
                class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
            >
                <i class="pi pi-bars navbarTogglerIcon" />
            </Button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"> Articles </a>
                    </li>
                </ul>
                <form class="searchForm" id="searchForm">
                    <InputText class="searchInput" placeholder="Search..." />
                    <i class="pi pi-search searchIcon" />
                </form>
            </div>
        </div>
    </nav>
</template>
