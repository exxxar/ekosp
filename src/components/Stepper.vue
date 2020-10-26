<template>
    <div>
        <step-zero v-if="step === 0" v-on:next-step="setStep(1)"/>
        <step-one v-if="step === 1" v-on:next-step="setStep(2)"/>
        <step-two v-if="step === 2" v-on:next-step="setStep(3)"/>
        <step-three v-if="step === 3" v-on:next-step="setStep(4)"/>
    </div>
</template>

<script>


    import StepZero from "@/components/Step0";
    import StepOne from "@/components/Step1";
    import StepTwo from "@/components/Step2";
    import StepThree from "@/components/Step3";

    export default {
        name: 'Stepper',
        data() {
            return {
                step: 0
            }
        },
        methods: {
            setStep(index) {
                this.step = index
            }
        },
        components: {
            StepZero, StepOne, StepTwo, StepThree
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
