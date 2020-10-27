<template>
    <div>
        <step-zero v-if="is_0_show" v-on:next-step="setStep(1)"/>
        <step-one v-if="is_1_show" v-on:next-step="setStep(2)"/>
        <step-two v-if="is_2_show" v-on:next-step="setStep(3)"/>
        <step-three v-if="is_3_show" v-on:next-step="setStep(4)"/>
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
                is_0_show: true,
                is_1_show: false,
                is_2_show: false,
                is_3_show: false,
                step: 0
            }
        },
        methods: {
            setStep(index) {
                this.step = index

                switch (this.step) {
                    case 0:
                        this.is_0_show = false;
                        break;
                    case 1:
                        this.is_1_show = true;
                        break;
                    case 2:
                        this.is_2_show = true;
                        break;
                    case 3:
                        this.is_3_show = true;
                        break;
                }
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
