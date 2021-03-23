<template>
    <div class="modal fade" ref="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <!-- Modal -->
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <template>
                        <a :href="route('oauth', {type: 'google'})" class="btn btn-danger btn-lg w-100 mb-3">
                            Login with Google
                        </a>
                        <a :href="route('oauth', {type: 'facebook'})" class="btn btn-primary btn-lg w-100 mb-3">
                            Login with Facebook
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vuex from 'vuex';

export default {
    data() {
        return {

        }
    },

    mounted() {
        console.log('Component mounted.')
        this.$loginModal.on('hidden.bs.modal', () => {
            this.hideModal();
        })
    },

    watch: {
        modalShow(newVal) {
            if (newVal) {
                this.$loginModal.modal('show');
            } else {
                this.$loginModal.modal('hide');
            }
        },
    },

    computed: {
        ...Vuex.mapGetters({
            modalShow: 'modalShow',
            route: 'route',
        }),

        $loginModal() {
            return $(this.$refs['loginModal']);
        },
    },

    methods: {
        ...Vuex.mapActions({
            openModal: 'openModal',
            hideModal: 'hideModal',
        }),
    },
}
</script>
