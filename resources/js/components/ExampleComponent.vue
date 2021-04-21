<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        Esto es un ejemplo de vue
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            window.Echo.channel('kobsa-tracker')
            .listen('OrderStatusChangedEvent', (e) => {
                console.log(e.message)
            })
        }
    }
</script>
