<template>
    <div>
        <div class="buyme" v-b-modal.modal-3>Купить</div>
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
    </div>

</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: '',
                    phone: '',
                    region: '',
                    message: ''
                }

            }
        },
        methods:{
            sendMail() {
                this.$bvModal.hide('modal-3')
                axios.post('mail_message.php', this.form)
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