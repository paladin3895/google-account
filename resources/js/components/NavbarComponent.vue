<template id="">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <template v-if="user">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <form :action="route('logout')" method="POST" class="">
                                    <button class="dropdown-item btn btn-link">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item">
                            <a v-on:click="openModal" class="nav-link" href="#" role="button">
                                Sign-in
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script charset="utf-8">
import Vuex from 'vuex';

export default {
    props: {

    },

    computed: {
        ...Vuex.mapGetters({
            user: 'user',
            route: 'route',
            config: 'config',
        })
    },

    methods: {
        ...Vuex.mapActions({
            openModal: 'openModal',
        })
    }
}
</script>
