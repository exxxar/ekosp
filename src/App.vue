<template>
    <div>
        <notifications group="foo" />
        <div class="container-md">
            <div class="row d-flex justify-content-center flex-wrap">
                <div class="col-lg-10 col-md-12 col-12">
                    <h1 class="bluetit text-center">Расчет объема, стоимости и экономической эффективности
                        применения «ЭКО-СП»</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pb-5">
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

<style class="scoped">


    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
    }

    .bluetit {
        font-size: 2.4em;
        font-weight: 200;
        color: #00a8e6;
        margin: 40px;
    }

</style>
