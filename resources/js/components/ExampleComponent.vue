<template>
    <div v-if="user" class="card">
        <div class="card-header">Example Component</div>

        <div class="card-body">
            I'm an example component.
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
