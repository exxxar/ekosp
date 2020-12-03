<template>
    <form v-on:submit.prevent="submit(0)" class="flex-wrap d-flex justify-content-center" id="step3">

        <h2>ШАГ 3: Расчет экономической эффективности применения препарата «ЭКО-СП»</h2>


        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.crop_area"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Площадь посевов">
                    <div class="input-group-append">
                        <span class="input-group-text">га</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.seeding_rate"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Норма высева">
                    <div class="input-group-append">
                        <span class="input-group-text">кг/га</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.planned_yield"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Планируемая урожайность">
                    <div class="input-group-append">
                        <span class="input-group-text">ц/га</span>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.yield_cost"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Стоимость урожая">
                    <div class="input-group-append">
                        <span class="input-group-text">руб/т</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="container itog">
            <div class="row">
                <div class="col-md-5">Предпосевная обработка семян:</div>
                <div class="col-md-3"><span>{{one.prepare.required_volume.toFixed(2)}}</span> л</div>
                <div class="col-md-3"><span>{{numberPrepare((one.prepare.required_volume*basePrice).toFixed(0))}}</span>
                    руб
                </div>
            </div>

            <div class="row" v-for="(vegetation, index) in one.vegetation">
                <div class="col-md-5">{{prepareTextNumber(index)}} обработка по вегетации:</div>
                <div class="col-md-3"><span>{{vegetation.required_volume.toFixed(0)}}</span> л</div>
                <div class="col-md-3"><span>{{numberPrepare((vegetation.required_volume*basePrice).toFixed(0))}}</span>
                    руб
                </div>
            </div>


            <hr class="w-100"/>

            <div class="row itogblue">
                <div class="col-md-5">Итоговые инвестиции хозяйства в покупку ЭКО-СП:</div>
                <div class="col-md-3"><span>{{currentVolume.toFixed(2)}}</span> л</div>
                <div class="col-md-3"><span>{{numberPrepare((currentVolume*basePrice).toFixed(0))}}</span> руб</div>
            </div>
            <div class="row itogblue">
                <div class="col-md-5">Прирост урожайности:</div>
                <div class="col-md-3"><span>{{getIncraceRate()}}</span> %</div>
                <div class="col-md-3"><span>{{getIncreaseCentners()}}</span> ц/га</div>
                <div class="col-md-1 col-sm-12 d-flex justify-content-center align-items-center " v-b-modal.modal-4><a
                    href="#calc-about" class="d-flex justify-content-center align-items-center text-center">
                    <div class="calc-about">?</div>
                </a></div>
            </div>
        </div>

        <div class="row d-flex align-items-center flex-column w-100 mt-5 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h5>Прибавка в деньгах<strong class="text-danger">*</strong>: <span>{{numberPrepare(getIncreaseMoney())}}</span>
                    руб
                </h5>
            </div>
        </div>
        <div class="row d-flex align-items-center w-100 flex-column w-100 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <p>Дополнительная выручка от продажи дополнительного объема урожая полученного от увеличения
                    урожайности.</p>
            </div>
        </div>

        <div class="row d-flex align-items-center w-100 flex-column rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h5 class="w-100">Чистая прибыль <strong class="text-danger">*</strong>: <span>{{numberPrepare(getNetProfit())}}</span>
                    руб</h5>
            </div>
        </div>
        <div class="row d-flex align-items-center w-100 flex-column w-100 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <p>Расчетная «чистая прибыль» от использования ЭКО-СП: дополнительная выручка минус расходы на покупку и
                    использование «ЭКО-СП» совместно с СЗР.</p>
            </div>
        </div>

        <div class="row d-flex align-items-center w-100 flex-column w-100 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h5>Рентабельность гектара <strong class="text-danger">*</strong>: <span>{{numberPrepare(getProfitability())}}</span>
                    руб</h5>
            </div>
        </div>
        <div class="row d-flex align-items-center w-100 flex-column w-100 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <p>Экономическая эффективность использования ЭКО-СП на 1 га</p>
            </div>
        </div>


        <div class="dis-line"></div>

        <div class="row d-flex justify-content-center w-100 mt-5">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <button type="button" class="btn success-custom w-100" v-b-modal.modal-8>
                    Сделать заявку /
                    Заказать звонок
                </button>
            </div>
        </div>

        <div class="row d-flex justify-content-center w-100 flex-wrap mb-2">
            <div class="col-lg-8 col-md-12 col-sm-12 mt-2">
                <button type="button" class="btn success-custom w-100" @click="submit(1)">Сохранить файл и выслать на
                    почту
                </button>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 mt-2">
                <button type="submit" class="btn btn-primary primary-custom w-100">Сгенерировать официальное
                    коммерческое предложение и
                    выслать на
                    почту
                </button>
            </div>
        </div>

        <b-modal id="modal-8" title="Обратная связь">

            <input type="text" id="name" v-model="form_message.name" placeholder="Введите имя *"
                   class="form-control mb-2">
            <input type="text" id="phone" v-model="form_message.phone" placeholder="Введите телефон *"
                   class="form-control  mb-2">
            <p>Выбор округа: *</p>
            <select class="form-control" v-model="form_message.region">
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
            <textarea placeholder="Введите сообщение" v-model="form_message.message" class="form-control"/>

            <template #modal-footer="{ ok, cancel }">
                <b-button size="sm" variant="success" @click="sendMail()">
                    Отправить
                </b-button>
                <b-button size="sm" variant="danger" @click="cancel()">
                    Закрыть!
                </b-button>
            </template>
        </b-modal>

        <b-modal id="modal-9" title="Авторизация">

            <div class="form-group">
                <input name="company"
                       v-model="form_auth.company"
                       type="text"

                       class="form-control form-control-lg"
                       placeholder="Название компании" >
            </div>

            <div class="form-group">
                <input name="region"
                       v-model="form_auth.region"
                       type="text"
                       class="form-control form-control-lg"
                       placeholder="Регион" >
            </div>

            <div class="form-group">
                <input name="name"
                       v-model="form_auth.name"
                       type="text"
                       class="form-control form-control-lg"
                       placeholder="ФИО" >
            </div>

            <div class="form-group">
                <input name="phone"
                       v-model="form_auth.phone"
                       maxlength="19"
                       type="text"
                       class="form-control form-control-lg"
                       placeholder="Номер телефона" >
            </div>


            <div class="form-group">
                <input name="email"
                       v-model="form_auth.email"
                       type="email"
                       class="form-control form-control-lg"
                       placeholder="Email" required>
            </div>

            <div class="form-group">
                <label class="pull-left" for="invite">Код приглашения <span style="color:#f00;">(если отсутствует - пропустить)</span>:</label>
                <input name="invite"
                       v-model="form_auth.invite"
                       type="text"
                       pattern="[AM].[0-9]{1,2}"
                       maxlength="19"
                       v-mask="['A ##']"
                       class="form-control form-control-lg"
                       id="invite" placeholder="">
            </div>

            <template #modal-footer="{ ok, cancel }">
                <b-button size="sm" variant="success" @click="submit2(0)" :disabled="form_auth.email.trim().length==0">
                    Отправить на почту
                </b-button>

                <b-button size="sm" variant="info" @click="submit2(1)" :disabled="form_auth.email.trim().length==0">
                    Сохранить файл
                </b-button>

                <b-button size="sm" variant="danger" @click="cancel()">
                    Закрыть!
                </b-button>
            </template>
        </b-modal>

        <b-modal id="modal-4" title="Информация" size="lg">
            <p>Множество агроиспытаний с научными организациями и полевые опыты в компаниях позволяют сделать следующие
                выводы об увеличении урожайности препаратом «ЭКО-СП»:</p>
            <p>- провели обработку семян <span class="text-primary font-weight-bold">+1,9%</span> увеличение
                урожайности;</p>
            <p>- первая обработка по вегетации <span class="text-primary font-weight-bold">+7%</span> увеличение
                урожайности;</p>
            <p>- вторая обработка по вегетации <span class="text-primary font-weight-bold">+4%</span> увеличение
                урожайности;</p>
            <p>- третья обработка по вегетации <span class="text-primary font-weight-bold">+1,4%</span> увеличение
                урожайности;</p>

            <p>
                При обработке по полному циклу (обработка семян и 3 обработки по вегетации) увеличение урожайности в
                среднем оставляет - <span class="text-primary font-weight-bold">14,3%</span>. </p>
            <p class="text-danger font-weight-bold">
                <em>Увеличивайте урожайность – зарабатывайте больше!</em></p>

            <template #modal-footer="{ cancel }">
                <b-button size="sm" variant="info" @click="cancel()">
                    Спасибо, прочитал!
                </b-button>
            </template>
        </b-modal>
    </form>
</template>
<script>

    export default {
        data() {
            return {
                vegetation: [0, 7, 11, 12.4],
                form_auth: {
                    required:false,
                    company: '',
                    region: '',
                    name: '',
                    phone: '',
                    email: '',
                    invite: '',
                },
                form: {
                    crop_area: null,
                    seeding_rate: null,
                    planned_yield: null,
                    yield_cost: null,
                    incrace_rate: null,
                    increase_centners: null,
                    increase_in_money: null,
                    net_profit: null,
                    profitability: null,
                },
                form_message: {
                    name: '',
                    phone: '',
                    region: '',
                    message: ''
                }
            }
        },
        watch: {

            'form.seeding_rate': function (newVal) {
                this.$store.dispatch("setSeedingRate", newVal)
            }
        },
        computed: {
            zero: function () {
                return this.$store.getters.Zero
            },
            two: function () {
                return this.$store.getters.Two
            },
            one: function () {
                return this.$store.getters.One
            },
            cropArea: function () {
                return this.$store.getters.GetCropArea
            },
            seedingRate: function () {
                return this.$store.getters.GetSeedingRate
            },
            basePrice: function () {
                return this.$store.getters.GetBasePrice
            },
            currentVolume: function () {
                return this.$store.getters.GetCurrentVolume
            },
            vegetationCount: function () {
                return this.$store.getters.GetVegetationCount
            }
        },
        mounted() {
            this.form.crop_area = this.cropArea
            this.form.seeding_rate = this.seedingRate
        },
        methods: {
            sendMail() {
                this.$bvModal.hide('modal-8')
                axios.post('m/mail_message.php', this.form_message)
                    .then(function (response) {
                        this.notify("Заявка успешно отправлена!")
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            numberPrepare(number) {
                return ('' + number).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
            },
            prepareTextNumber(number) {
                let arr = ["Первая", "Вторая", "Третья"];
                return arr[number > 0 && number < arr.length ? number : 0]
            },
            getIncraceRate() {
                let preparation = !this.one.need_seed_preparation ? 1.9 : 0;
                let result = this.vegetation[this.vegetationCount] + preparation
                this.form.incrace_rate = result
                return result;
            },
            getIncreaseCentners() {
                if (this.form.planned_yield == null)
                    return 0;

                let preparation = !this.one.need_seed_preparation ? 1.9 : 0;


                let result = (this.form.planned_yield / 100 * (this.vegetation[this.vegetationCount] + preparation)).toFixed(2)
                this.form.increase_centners = result;
                return result;

            },
            getIncreaseMoney() {
                if (this.form.crop_area == null)
                    return 0;

                let result = ((this.form.crop_area * this.getIncreaseCentners() * this.form.yield_cost) / 10).toFixed(0)
                this.form.increase_in_money = result
                return result;
            },
            getNetProfit() {
                // return (this.getIncreaseMoney() * (this.basePrice * this.currentVolume)).toFixed(2)
                let result = (Math.abs((this.basePrice * this.currentVolume) - this.getIncreaseMoney())).toFixed(0)

                this.form.net_profit = result

                return result

            },
            getProfitability() {
                if (this.form.crop_area == null)
                    return 0;


                let result = Math.abs((this.getNetProfit() / this.form.crop_area)).toFixed(0)

                this.form.profitability = result

                return result;
            },
            submit2(type){
                this.$bvModal.hide('modal-9')
                this.$store.dispatch('setStepZero', this.form_auth)
                this.$store.dispatch("setStepThree", this.form)
                this.$store.dispatch("submitResult", type)
                this.notify(type === 0 ?
                    "Заявка успешно отправлена! Спасибо что выбрали нас!" :
                    "Мы генерируем результат и отправляем его Вам на почту!"
                )
            },
            submit(type) {
                if (!this.zero.required)
                    this.$bvModal.show('modal-9')
                else {
                    this.$store.dispatch("setStepThree", this.form)
                    this.$store.dispatch("submitResult", type)
                    this.notify(type === 0 ?
                        "Заявка успешно отправлена! Спасибо что выбрали нас!" :
                        "Мы генерируем результат и отправляем его Вам на почту!"
                    )
                }
            },
            notify(text) {
                this.$notify({
                    group: 'foo',
                    title: 'ЭКО-СП',
                    type: 'success',
                    text: text
                });
            }
        }
    }
</script>

<style lang="scss" scoped>

    .input-group-text {
        padding: 0 15px 0 15px;
        min-width: 80px;
        display: flex;
        justify-content: center;
    }

    .rez-panel {

        h5 {
            padding: 10px;
            background: #eee;
            border: 1px lightgray solid;

            span {
                padding: 10px;
                border: 2px lightskyblue solid;
                background: white;
                border-radius: 5px;
                display: inline-block;
            }
        }
    }

    .calc-about {
        width: 025px;
        height: 25px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        font-weight: 100;

        display: flex;
        justify-content: center;
        align-items: center;

        &:focus {
            outline: none;
        }
    }

    .itog {
        padding: 20px;
        font-weight: 600;
        line-height: 200%;
        border-radius: 5px;
        border: 1px lightgray solid;

        .itogblue {
            color: deepskyblue;
        }
    }
</style>