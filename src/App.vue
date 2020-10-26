<template>
    <div id="app">
        <div class="container-md">
            <div class="row">
                <div class="col-md-12">
                    <stepper/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    import sassStyles from '@/assets/style.scss'
    import Stepper from './components/Stepper.vue'

    export default {
        name: 'App',
        components: {
            Stepper
        }
    }
</script>

<style>


    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }

</style>
