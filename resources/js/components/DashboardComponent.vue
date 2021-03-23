<template>
    <div v-if="user" class="card">
        <div class="card-header">Your Google profile</div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">
                    <img :src="user.photo" :alt="user.name" class="img-thumbnail">
                </div>
                <div class="col-sm-4">
                    <p>Email: {{ user.email }}</p>
                    <p>Name: {{ user.name }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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

    }
}
</script>
