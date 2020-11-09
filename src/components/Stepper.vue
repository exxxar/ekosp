<template>
    <div>
        <step-zero v-if="is_0_show" v-on:next-step="setStep(1)"/>
        <step-one  v-if="is_1_show" v-on:next-step="setStep(2)"/>
        <step-two  v-if="is_2_show" v-on:next-step="setStep(3)"/>
        <step-three  v-if="is_3_show" v-on:next-step="setStep(4)"/>
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
                        console.log("is_0_show")
                        break;
                    case 1:
                        this.is_1_show = true;
                        console.log("is_1_show")
                        this.$nextTick(()=>{
                            this.$scrollTo("#step1", {
                                offset:-100
                            } )
                        })
                        break;
                    case 2:
                        this.is_2_show = true;
                        console.log("is_2_show")
                        this.$nextTick(()=>{
                            this.$scrollTo("#step2",{
                                offset:-150
                            })
                        })
                        break;
                    case 3:
                        this.is_3_show = true;
                        console.log("is_3_show")
                        this.$nextTick(()=>{
                            this.$scrollTo("#step3",{
                                offset:-150
                            })

                        })
                        break;
                }
            }
        },
        components: {
            StepZero, StepOne, StepTwo, StepThree
        }
    }
</script>

<style lang="scss">
    .primary-custom {
        font-weight: bold;
        font-size: 18px;
        color: #fff;
        padding: 15px;
        background: #00a8e6;
        border-top: 0px;
        border-left: 0px;
        border-right: 0px;
        border-bottom: 4px solid #0086b8;
        white-space: pre-line;
    }

    .success-custom {
        font-weight: bold;
        font-size: 18px;
        color: #fff;
        padding: 10px 15px;
        background: #00bb1d;
        border-top: 0px;
        border-left: 0px;
        border-right: 0px;
        border-bottom: 4px solid #008915;
        white-space: pre-line;
    }

    .calc-about {
        width: 25px;
        height: 25px;
        background: #00a8e6;
        color: white;
        border-radius: 50%;
    }

    @media (max-width: 420px) {
        h1, h2 {
            font-size: 18px !important;
        }

        h4,
        h3 {
            font-size: 16px !important;
        }

        .dis-seasons2 {
            font-size: 12px !important;
        }

        p,
        .part,
        .success-custom,
        .primary-custom,
        .form-control,
        label,
        input,
        h5 {
            font-size: 14px !important;
        }

    }

</style>
