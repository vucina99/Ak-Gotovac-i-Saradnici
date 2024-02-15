<template>
    <div>
        <modal :name="'edit-trial-modal'" @before-open="beforeOpenEdit" :shiftY="0.1" :scrollable="true"
               :adaptive="true" :resizable="true" height="auto">
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-4  d-flex justify-content-end w-100 ">
                        <div class="text-right w-25 " @click="closeModal()">
                            <i class="fa fa-times fa-2x text-muted" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="add-type choose-type">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="choose-type">
                                <div class="container">
                                    <div class="row">
                                        <div
                                            class="type-div-size type-div-size-back  bg-blue text-light pt-2 pb-2 d-flex align-items-center justify-content-center border-light-full">
                                            <span>DATUM : {{ date_selected }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="choose-type w-100">
                                <div class="container bg-personal-light">
                                    <div class="row">
                                        <div class="col-12"><br>

                                            <vue-confirm-dialog></vue-confirm-dialog>
                                            <div class="w-100" v-if="data == null  || loader">
                                                <vue-simple-spinner></vue-simple-spinner>
                                            </div>
                                            <div v-if="success &&  !loader"
                                                 class="alert error-danger alert-success alert-dismissible fade show"
                                                 role="alert">
                                                <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; SLUĆAJ JE USPEŠNO IZMENJEN</span>
                                                <button @click.prevent="success = false" type="button" class="close"

                                                >
                                                    <span>&times;</span>
                                                </button>
                                            </div>

                                            <form action="" method="post" class="add-form-modal " :hidden="loader" v-if="data !== null">
                                                <div class="form-group search-font-size-modal ">
                                                    <label>SUD</label>
                                                    <v-select
                                                        :options="institutions_serchData"
                                                        :id="'courts'"
                                                        label="name"
                                                        placeholder="SUD"
                                                        v-model="data.institution"
                                                    >
                                                    </v-select>
                                                </div>

                                                <div class="form-group search-font-size-modal ">
                                                    <label>ZADUŽENI</label>
                                                    <v-select
                                                        :options="users"
                                                        :id="'responsible'"
                                                        label="name"
                                                        v-model="data.user"
                                                        placeholder="ZADUŽENI"
                                                    >
                                                    </v-select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="number_court">BROJ U KANCELARIJI</label>
                                                    <input type="text" class="form-control"
                                                           id="number_court"
                                                           v-model="data.numberOffice"
                                                           placeholder="BROJ U KANCELARIJI">
                                                </div>

<!--                                                <div class="form-group">-->
<!--                                                    <label for="number_institutions">BROJ U INSTITUCIJI</label>-->
<!--                                                    <input type="text" class="form-control" id="number_institutions"-->
<!--                                                           placeholder="BROJ U KANCELARIJI"-->
<!--                                                           v-model="data.numberInstitution">-->
<!--                                                </div>-->


                                                <div class="form-group ">

                                                    <label for="client1">BROJ SUDNICE</label>

                                                    <input type="text" class="form-control" id="courtroom_number"
                                                           placeholder="BROJ SUDNICE" v-model="data.courtroom_number">
                                                </div>


                                                <div class="form-group ">

                                                    <label for="client1">STRANKA 1</label>

                                                    <input type="text" class="form-control"
                                                           id="client1"
                                                           v-model="data.prosecutor"
                                                           placeholder="STRANKA 1">
                                                </div>
                                                <div class="form-group ">

                                                    <label for="client2">STRANKA 2</label>

                                                    <input type="text" class="form-control"
                                                           id="client2"
                                                           v-model="data.defendants"
                                                           placeholder="STRANKA 2">
                                                </div>


                                                <div class="form-group" >
                                                    <label  for="archiva">P BROJ</label>
                                                    <input type="text" class="form-control"
                                                           v-model="data.archive " id="archiva"
                                                           :placeholder="'P BROJ'">
                                                </div>

                                                <div class="pb-3">
                                                    <label for="time">VREME</label>
<!--                                                    <div class="input-group custom-file-button">-->
<!--                                                        <date-picker v-model="data.time" id="time"-->
<!--                                                                     type="time" format="HH:mm"-->
<!--                                                                     placeholder="VREME"></date-picker>-->

<!--                                                    </div>-->
                                                    <input type="text" class="form-control" id="time"
                                                           placeholder="VREME (upisati vreme u formatu 15:05)" v-model="data.time">
                                                </div>

                                                <div class="form-group">
                                                    <label for="notes">BELEŠKA</label>
                                                    <vue-editor id="notes"
                                                                :editorToolbar="customToolbar"
                                                                v-model="data.note"></vue-editor>
                                                </div>
                                                <div class="pb-4 pt-4">
                                                    <button class="btn btn-primary w-100" @click.prevent="editTrial()"> IZMENI ROČIŠTE &nbsp; <i
                                                        class="fa fa-spinner" aria-hidden="true"></i>
                                                    </button>
                                                </div>

                                                <div>
                                                    <button class="btn btn-danger w-100" @click.prevent="deleteTrial()">
                                                        OBRIŠI ROČIŠTE &nbsp; <i
                                                        class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <br><br>
        </modal>
    </div>

</template>

<script>

import vSelect from "vue-select";
import {VueEditor} from "vue2-editor";
import DatePicker from 'vue2-datepicker';


export default {
    name: "EditTrial",
    props: ['date_selected' , 'institutions_serchData'],
    data() {
        return {
            data: null,
            loader : false,
            trialIndex: -1,
            date: '',
            lang: 'sr',
            success: false,
            users : [],
            customToolbar: [
                [{header: [false, 1, 2, 3, 4, 5, 6]}],
                ["bold", "italic", "underline", "strike"],
                [{list: "ordered"}, {list: "bullet"}],
                [
                    {align: ""},
                    {align: "center"},
                    {align: "right"},
                    {align: "justify"}
                ],
                [{color: []}, {background: []}],
                [{indent: "-1"}, {indent: "+1"}],
            ]
        }
    },
    components: {
        'v-select': vSelect,
        VueEditor,
        DatePicker

    },
    methods: {
        deleteTrial(){

            this.$confirm({
                message: 'DA LI STE SIGURNI DA ŽELITE DA OBRIŠETE ROČIŠTE?',
                button: {
                    no: 'NE',
                    yes: 'DA'
                },
                /**
                 * Callback Function
                 * @param {Boolean} confirm
                 */
                callback: confirm => {
                    if (confirm) {
                        axios.delete('/trial/delete/trial/' + this.data.id ).then(({data}) => {


                            this.$confirm({
                                message: 'USPEŠNO BRISANJE',
                                button: {
                                    yes: 'OK'
                                },
                                /**
                                 * Callback Function
                                 * @param {Boolean} confirm
                                 */
                                callback: confirm => {
                                    if (confirm) {
                                        this.$root.$emit('removeTrialFromArray', this.trialIndex);

                                        this.closeModal();
                                    }
                                }
                            })


                        }).catch((error) => {
                            alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
                        })
                    }
                }
            })



        },
        editTrial(){
            this.success = false
            this.loader = true
            axios.patch('/trial/edit/trial/' + this.data.id, this.data).then(({data}) => {
                this.success = true;
                this.$root.$emit('addEditedTrialInArray', {'trialData': data, 'trialIndex': this.trialIndex});
                this.loader = false
            }).catch((error) => {
                alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
            })

        },
        getUsers() {
            axios.get('/trial/get/users').then(({data}) => {
                this.users = data;
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })

        },
        beforeOpenEdit(event) {
            this.data = JSON.parse(JSON.stringify(event.params.data)) ;
            this.trialIndex = event.params.index
            // this.data.time = new Date(this.data.date + ' ' + this.data.time) ;
            this.success = false
        },

        closeModal() {
            this.$modal.hide('edit-trial-modal');
        }
    },
    created() {
        this.getUsers();
    }
}
</script>

<style scoped lang="scss">
@import 'vue2-datepicker/index.css';
@import "vue-select/dist/vue-select.css";
@import "/public/css/style.css";
@import "/public/css/responsive.css";

.custom-file-button {
    input[type="file"] {
        margin-left: -2px !important;

        &::-webkit-file-upload-button {
            display: none;
        }

        &::file-selector-button {
            display: none;
        }
    }

    &:hover {
        span {
            background-color: #dde0e3;
            cursor: pointer;
        }
    }
}

.input-group-text {
    font-size: 12px;
}

</style>
