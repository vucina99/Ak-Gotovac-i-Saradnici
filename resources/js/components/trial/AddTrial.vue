<template>
    <div>
        <button class="btn btn-success w-100" @click.prevent="modalShow()">
            DODAJ <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <modal name="add-trial-modal" :shiftY="0.1" :scrollable="true" :adaptive="true" :resizable="true" height="auto">
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
                                            <div v-if="success"
                                                 class="alert error-danger alert-success alert-dismissible fade show"
                                                 role="alert">
                                                <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; ROČIŠTE JE USPEŠNO DODAT</span>
                                                <button @click.prevent="success = false" type="button" class="close"

                                                >
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="post" class="add-form-modal ">
                                                <div class="form-group search-font-size-modal ">
                                                    <label>INSTITUCIJA</label>
                                                    <v-select
                                                        :options="institutions_serchData"
                                                        :id="'courts'"
                                                        label="name"
                                                        v-model="trialData.institution"
                                                        placeholder="INSTITUCIJA">
                                                    </v-select>
                                                </div>

                                                <div class="form-group search-font-size-modal ">
                                                    <label>ZADUŽENI</label>
                                                    <v-select
                                                        :options="users"
                                                        :id="'responsible'"
                                                        label="name"
                                                        v-model="trialData.user"
                                                        placeholder="ZADUŽENI"
                                                    >
                                                    </v-select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="number_office">BROJ U KANCELARIJI</label>
                                                    <input type="text" class="form-control" id="number_office"
                                                           placeholder="BROJ U KANCELARIJI"
                                                           v-model="trialData.number_office">
                                                </div>

<!--                                                <div class="form-group">-->
<!--                                                    <label for="number_institutions">BROJ U INSTITUCIJI</label>-->
<!--                                                    <input type="text" class="form-control" id="number_institutions"-->
<!--                                                           placeholder="BROJ U INSTITUCIJI"-->
<!--                                                           v-model="trialData.number_institution">-->
<!--                                                </div>-->


                                                <div class="form-group ">

                                                    <label for="client1">BROJ SUDNICE</label>

                                                    <input type="text" class="form-control" id="courtroom_number"
                                                           placeholder="BROJ SUDNICE" v-model="trialData.courtroom_number">
                                                </div>

                                                <div class="form-group ">

                                                    <label for="client1">STRANKA 1</label>

                                                    <input type="text" class="form-control" id="client1"
                                                           placeholder="STRANKA 1" v-model="trialData.person_1">
                                                </div>
                                                <div class="form-group ">

                                                    <label for="client2">STRANKA 2</label>

                                                    <input type="text" class="form-control" id="client2"
                                                           placeholder="STRANKA 2" v-model="trialData.person_2">
                                                </div>

                                                <div class="form-group" >
                                                    <label  for="archiva">P BROJ</label>
                                                    <input type="text" class="form-control"
                                                           v-model="trialData.archive " id="archiva"
                                                           :placeholder="'P BROJ'">
                                                </div>

                                                <div class="pb-3">
                                                    <label for="time">VREME</label>
<!--                                                    <div class="input-group custom-file-button">-->
<!--                                                        <date-picker v-model="trialData.time" :language="lang" id="time"-->
<!--                                                                     type="time"-->
<!--                                                                     format="HH:mm" placeholder="VREME"></date-picker>-->

<!--                                                    </div>-->
                                                    <input type="text" class="form-control" id="time"
                                                           placeholder="VREME (upisati vreme u formatu 15:05)" v-model="trialData.time">
                                                </div>

                                                <div class="form-group">
                                                    <label for="notes">BELEŠKA</label>
                                                    <vue-editor id="notes" v-model="trialData.note"
                                                                :editorToolbar="customToolbar"></vue-editor>
                                                </div>


                                                <div class="pb-4 pt-4">
                                                    <button class="btn btn-primary w-100"
                                                            @click.prevent="createTrial()"> DODAJ ROČIŠTE &nbsp; <i
                                                        class="fa fa-spinner" aria-hidden="true"></i>
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
    name: "AddTrial",
    props: ['date_selected', 'institutions_serchData'],
    data() {
        return {
            data: [],
            content: '',
            type: 5,
            lang: 'sr',
            users: [],
            success: false,
            trialData: {
                institution: '',
                user: '',
                number_office: '',
                number_institution: '',
                person_1: '',
                person_2: '',
                date: this.date_selected,
                time: '',
                note: '',
                courtroom_number:'',
                archive: ''
            },
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
    created() {
        this.getUsers();
    },
    methods: {
        createTrial() {
            console.log(this.trialData);
            axios.post('/trial/create/trial', this.trialData).then(({data}) => {
                this.success = true;
                this.$root.$emit("addNewTrialInArray", data);
                this.trialData = {
                    institution: '',
                    user: '',
                    number_office: '',
                    number_institution: '',
                    date: this.date_selected,
                    person_1: '',
                    person_2: '',
                    time: '',
                    note: ''
                }
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        },
        modalShow() {
            this.success = false
            this.trialData = {
                institution: '',
                user: '',
                number_office: '',
                number_institution: '',
                person_1: '',
                person_2: '',
                date: this.date_selected,
                time: '',
                note: ''
            },
            this.$modal.show('add-trial-modal');
        },
        closeModal() {
            this.$modal.hide('add-trial-modal');
        },
        getUsers() {
            axios.get('/trial/get/users').then(({data}) => {
                this.users = data;
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        }
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
