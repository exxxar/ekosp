<template>
    <form v-on:submit.prevent="submit" class="flex-wrap d-flex justify-content-center mb-5">

        <h2 class="w-100">ШАГ 2: Расчет стоимости препарата «ЭКО-СП»</h2>


        <div class="row w-100" style="text-align:left;max-width:600px;">
            <div class="col-md-5">
                <div class="input-group mb-3">
                    <input name="humiccost"
                           v-model="humic_price"
                           class="form-control input-lg">
                    <div class="input-group-append">
                        <span class="input-group-text">руб/л</span>
                    </div>
                </div>

            </div>
            <div class="col-md-7" style="margin-top:10px;text-align:left;">
                Базовая расчётная цена на <strong><span id="current_date_time_block">19.10.2020</span></strong>
            </div>
        </div>

        <h6 class="mt-3 mb-3 w-100">Если вы не знаете текущую расчетную стоимость препарата, свяжитесь<br>с нашим
            менеджером по телефону <span class="text-danger font-weight-bold">8(800)707-53-94</span></h6>

        <h5 class="gray mt-3 mb-3">Скидка от базовой цены в зависимости от объема закупки:</h5>


        <div class="row w-100">
            <div class="col-md-6 discountblock">
                <h4>Ваш объём: <span>{{currentVolume.toFixed(2)}}</span> л</h4>
                <ul class="dis1">
                    <li v-for="dis in volume_discount_list">
                        <p v-if="dis.to_vol!=null"><span :style="selectColor(dis)">{{dis.discount}}%</span> - от
                            {{dis.from_vol}} до
                            {{dis.to_vol}} литров<br></p>
                        <p v-else><span :style="selectColor(dis)">{{dis.discount}}%</span> - от {{dis.from_vol}}
                            литров<br></p>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 d-flex justify-content-start flex-wrap align-items-end">

                <div class="volume text-left">
                    <p>Цена за литр продукции:<br><span>{{basePrice}}</span> руб</p>
                    <p>Стоимость объёма продукции с учетом скидки:<br><span>{{(basePrice*currentVolume).toFixed(2)}}</span> руб</p>
                </div>


            </div>
        </div>


        <h5 class="gray mt-3 mb-3">Скидка за покупку в сезон скидок:</h5>


        <div class="row w-100">
            <div class="col-md-6 discountblock">
                <div class="row dis-seasons p-2 text-white">
                    <div class="col-4 p-1"><span class="bg-success d-flex justify-content-center">5%</span></div>
                    <div class="col-4 p-1"><span class="bg-success d-flex justify-content-center">3%</span></div>
                    <div class="col-4 p-1"><span class="bg-success d-flex justify-content-center">2%</span></div>
                </div>

                <div class="row dis-seasons2">
                    <div class="col-3 text-left">Ноябрь</div>
                    <div class="col-3 text-left">Декабрь</div>
                    <div class="col-3 text-right">Январь</div>
                    <div class="col-3 text-right">Февраль</div>
                </div>

                <div class="row seasons-radio mt-2">
                    <ul class="p-2">
                        <li class="p-2">
                            <label><input type="radio" v-model="season_discount" :value="0" name="optradio2"
                                          class="mr-2">Без скидки</label>
                        </li>
                        <li class="p-2">
                            <label><input type="radio" v-model="season_discount" :value="1" name="optradio2"
                                          class="mr-2">Воспользоваться сезонной скидкой в
                                5%</label>
                        </li>
                        <li class="p-2">
                            <label><input type="radio" v-model="season_discount" :value="2" name="optradio2"
                                          class="mr-2">Воспользоваться сезонной скидкой в
                                3%</label>
                        </li>
                        <li class="p-2">
                            <label><input type="radio" v-model="season_discount" :value="3" name="optradio2"
                                          class="mr-2">Воспользоваться сезонной скидкой в
                                2%</label>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-6 d-flex justify-content-start flex-wrap align-items-end">

                <div class="volume text-left">
                    <p>Цена за литр продукции:<br><span>{{basePrice}}</span> руб</p>
                    <p>Стоимость объёма продукции с учетом скидки:<br><span>{{(basePrice*currentVolume).toFixed(2)}}</span> руб</p>
                </div>


            </div>
        </div>


        <h5 class="gray mt-3 mb-3">Скидка для членов <a href="https://www.akkor.ru/" target="_blank">АККОР</a> - 10%:
        </h5>


        <div class="row w-100">
            <div class="col-md-6 discountblock d-flex justify-content-center align-items-center" style="height: 80px">

                <div class="akkor"><label class="checkbox-inline"><input type="checkbox"
                                                                         v-model="is_discount_for_AKKOR_members"
                                                                         class="mr-2">Являюсь
                    членом АККОР</label></div>

            </div>
            <div class="col-md-6 d-flex justify-content-start flex-wrap align-items-end">

                <div class="volume text-left">
                    <p>Цена за литр продукции:<br><span>{{basePrice}}</span> руб</p>
                    <p>Стоимость объёма продукции с учетом скидки:<br><span>{{(basePrice*currentVolume).toFixed(2)}}</span> руб</p>
                </div>


            </div>
        </div>


        <h5 class="gray mt-3 mb-3">Скидка от модели оплаты:</h5>


        <div class="row w-100 ">
            <div class="col-md-6 discountblock seasons-radio">
                <ul class="p-2">
                    <li class="p-2">
                        <label><input type="radio" v-model="pay_method_discount" :value="2" name="optradio3"
                                      class="mr-2">Без скидки</label>
                    </li>
                    <li class="p-2">
                        <label><input type="radio" v-model="pay_method_discount" :value="0" name="optradio3"
                                      class="mr-2">3% при 100% предоплаты</label>
                    </li>
                    <li class="p-2">
                        <label><input type="radio" v-model="pay_method_discount" :value="1" name="optradio3"
                                      class="mr-2">2% при оплате 75%/25%</label>
                    </li>
                </ul>
            </div>

            <div class="col-md-6 d-flex justify-content-start flex-wrap align-items-end">

                <div class="volume text-left">
                    <p>Цена за литр продукции:<br><span>{{basePrice}}</span> руб</p>
                    <p>Стоимость объёма продукции с учетом скидки:<br><span>{{(basePrice*currentVolume).toFixed(2)}}</span> руб</p>
                </div>


            </div>
        </div>


        <hr class="w-100">


        <div class="row d-flex justify-content-center w-100 mt-2 bordered">
            <div class="col-md-5">
                <p>Ваша общая скидка:<br><span>{{summaryDiscount}}</span> %</p>
            </div>
            <div class="col-md-7">
                <p>Ваша цена за литр продукции:<br><span>{{basePrice}}</span> руб</p>
            </div>
            <div class="col-md-12">
                Стоимость объёма продукции ({{currentVolume.toFixed(2)}} л.) с учётом
                скидки:<br><span>{{(basePrice*currentVolume).toFixed(2)}}</span> руб
            </div>
        </div>


        <div class="row d-flex justify-content-center w-100 mt-2">
            <div class="col-md-8 col-sm-12">
                <button type="button" class="btn btn-success w-100" v-b-modal.modal-3>
                    Сделать заявку /
                    Заказать звонок
                </button>
            </div>
        </div>

        <div class="row d-flex justify-content-center mt-2 w-100" v-if="is_show">
            <div class="col-md-8 col-sm-12">

                <button type="submit" class="btn btn-primary w-100">ШАГ 3: Расчет экономической эффективности
                    применения
                    препарата «ЭКО-СП»
                </button>

            </div>
        </div>


        <b-modal id="modal-3" title="Обратная связь">

            <input type="text" id="name" v-model="form.name" placeholder="Введите имя *" class="form-control mb-2">
            <input type="text" id="phone" v-model="form.phone" placeholder="Введите телефон *"
                   class="form-control  mb-2">
            <p>Выбор округа: *</p>
            <select class="form-control" v-model="form.region">
                <option>Центральный ФО</option>
                <option>Северо-Западный ФО</option>
                <option>Южный ФО</option>
                <option>Северо-Кавказский ФО</option>
                <option>Приволжский ФО</option>
                <option>Уральский ФО</option>
                <option>Сибирский ФО</option>
                <option>Дальневосточный ФО</option>
            </select>
            <br>
            <textarea placeholder="Введите сообщение" v-model="form.message" class="form-control"/>

            <template #modal-footer="{ ok, cancel }">
                <b-button size="sm" variant="success" @click="sendMail()">
                    Отправить
                </b-button>
                <b-button size="sm" variant="danger" @click="cancel()">
                    Закрыть!
                </b-button>
            </template>
        </b-modal>


    </form>
</template>
<script>
    export default {
        data() {
            return {
                is_show:true,
                is_discount_for_AKKOR_members: false,
                pay_method_discount: 0,
                season_discount: 0,
                humic_price: null,
                form: {
                    name: '',
                    phone: '',
                    region: '',
                    message: ''
                }

            }
        },
        watch: {
            humic_price: function (newVal) {
                return this.$store.dispatch("setBasePrice", newVal)
            },
            is_discount_for_AKKOR_members: function (newVal) {
                return this.$store.dispatch("setIsAkkorMember", newVal)
            },
            pay_method_discount: function (newVal) {
                return this.$store.dispatch("setPayMethod", newVal)

            },
            season_discount: function (newVal) {
                return this.$store.dispatch("setSeasonDiscount", newVal)
            }
        },
        computed: {
            stepZero: function () {
                return this.$store.getters.Zero
            },
            pay_method_discount_list: function () {
                return this.$store.getters.GetPayMethodDiscountList
            },
            season_discount_list: function () {
                return this.$store.getters.GetSeasonDiscountList
            },
            volume_discount_list: function () {
                return this.$store.getters.GetVolumeDiscountList
            },
            summaryDiscount: function () {
                return this.$store.getters.GetSummaryDiscount;
            },
            currentVolume: function () {
                return this.$store.getters.GetCurrentVolume;
            },
            basePrice: function () {
                return this.$store.getters.GetBasePrice
            }
        },
        mounted() {
            if (this.stepZero != null) {
                this.form.name = this.stepZero.name
                this.form.region = this.stepZero.region
                this.form.phone = this.stepZero.phone
            }

            this.humic_price = this.basePrice

        },
        methods: {
            selectColor(dis) {
                return (dis.to_vol != null ?
                        dis.from_vol <= this.currentVolume && dis.to_vol > this.currentVolume :
                        dis.from_vol <= this.currentVolume
                ) ? "color:red" : "color:lightskyblue";
            },
            submit() {
                this.$store.dispatch('setStepTwo', this.form)
                this.is_show = false;
                this.$emit("next-step")
            },
            sendMail() {
                this.$bvModal.hide('modal-3')
                axios.post('/send-message.php', this.form)
                    .then(function (response) {
                        // handle success
                        console.log(response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            }
        }
    }
</script>

<style lang="scss">

    .volume {
        span {

            background: white;
            padding: 10px;
            border: 2px lightskyblue solid;
            border-radius: 5px;
            font-weight: 800;
            color: black;
            display: inline-block;

        }
    }

    .discountblock {
        border: 1px #eee solid;
        border-radius: 5px;
        text-align: left;

        h4 {
            padding: 20px 0px 20px 5px;
            font-weight: 900;
            font-size: 14px;
            border-bottom: 1px #eee solid;

            span {
                background: white;
                padding: 10px;
                border: 2px lightskyblue solid;
                border-radius: 5px;
                font-weight: 800;
                color: black;

                margin-left: 10px;
            }
        }
    }

    .dis1 {
        list-style: none;
        padding-left: 10px;

        li {
            p {
                margin: 0;

                span {
                    color: lightskyblue;
                    font-weight: bolder;
                }

            }
        }
    }

    h5.gray {
        background: #eee;
        width: 100%;
        font-size: 16px;
        padding: 5px 10px;
        font-weight: bold;
        text-align: left;
    }

    .seasons-radio {
        border-top: 1px #eee solid;

        li {
            list-style: none;
        }
    }

    .bordered {
        border: 4px lightgray solid;
        box-sizing: border-box;

        & > div {
            border: 1px #eee solid;
            padding: 10px;
            font-weight: 600;

            span {
                background: white;
                padding: 10px;
                border: 2px lightskyblue solid;
                border-radius: 5px;
                font-weight: 800;
                color: black;
                display: inline-block;
            }

            &:nth-child(1) {
                border-top: none;
            }

            &:nth-child(2) {
                border-top: none;
            }

            &:nth-child(3) {
                border-bottom: none;
            }
        }
    }
</style>