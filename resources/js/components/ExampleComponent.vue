<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">SocketIO</div>

                    <div class="card-body">
                        {{message}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let vue = this;
            window.Echo.channel('kobsa-tracker')
            .listen('OrderStatusChangedEvent', (e) => {
                vue.message = e.message;
            })
        },

        data() {
            return {
                message:''
            }
        },
    }
</script>
