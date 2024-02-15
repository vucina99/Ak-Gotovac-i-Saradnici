<template>
    <div>

        <modal name="show-trial-modal" @before-open="beforeOpenShow" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">
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
                                            <form action="" method="post" class="add-form-modal ">
                                                <div class="form-group search-font-size-modal ">
                                                    <label>SUD</label>
                                                    <v-select
                                                        :options="[]"
                                                        :id="'courts'"
                                                        label="name"
                                                        placeholder="SUD"
                                                        v-model="data.institution"
                                                        :disabled="true">
                                                    </v-select>
                                                </div>

                                                <div class="form-group search-font-size-modal ">
                                                    <label>ZADUŽENI</label>
                                                    <v-select
                                                        :options="[]"
                                                        :id="'responsible'"
                                                        label="name"
                                                        v-model="data.user"
                                                        placeholder="ZADUŽENI"
                                                        :disabled="true">
                                                    </v-select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="number_court">BROJ U KANCELARIJI</label>
                                                    <input type="text" :disabled="true" class="form-control"
                                                           id="number_court"
                                                           v-model="data.numberOffice"
                                                           placeholder="BROJ U KANCELARIJI">
                                                </div>

<!--                                                <div class="form-group">-->
<!--                                                    <label for="number_institutions">BROJ U INSTITUCIJI</label>-->
<!--                                                    <input type="text" class="form-control" id="number_institutions"-->
<!--                                                           placeholder="BROJ U KANCELARIJI"-->
<!--                                                           disabled-->
<!--                                                           v-model="data.numberInstitution">-->
<!--                                                </div>-->


                                                <div class="form-group ">

                                                    <label for="client1">BROJ SUDNICE</label>

                                                    <input type="text"  disabled class="form-control" id="courtroom_number"
                                                           placeholder="BROJ SUDNICE" v-model="data.courtroom_number">
                                                </div>

                                                <div class="form-group ">

                                                    <label for="client1">STRANKA 1</label>

                                                    <input type="text" :disabled="true" class="form-control"
                                                           id="client1"
                                                           v-model="data.prosecutor"
                                                           placeholder="STRANKA 1">
                                                </div>
                                                <div class="form-group ">

                                                    <label for="client2">STRANKA 2</label>

                                                    <input type="text" :disabled="true" class="form-control"
                                                           id="client2"
                                                           v-model="data.defendants"
                                                           placeholder="STRANKA 2">
                                                </div>

                                                <div class="form-group" >
                                                    <label  for="archiva">P BROJ</label>
                                                    <input type="text" :disabled="true" class="form-control"
                                                           v-model="data.archive " id="archiva"
                                                           :placeholder="'P BROJ'">
                                                </div>
                                                <div class="pb-3">
                                                    <label for="time">VREME</label>
<!--                                                    <div class="input-group custom-file-button">-->
<!--                                                        <date-picker :disabled="true" v-model="data.time" id="time"-->
<!--                                                                     type="time" format="HH:mm"-->
<!--                                                                     placeholder="VREME"></date-picker>-->

<!--                                                    </div>-->
                                                    <input type="text" disabled class="form-control" id="time"
                                                           placeholder="VREME (upisati vreme u formatu 15:05)" v-model="data.time">
                                                </div>

                                                <div class="form-group">
                                                    <label for="notes">BELEŠKA</label>
                                                    <vue-editor id="notes" :disabled="true"
                                                                :editorToolbar="customToolbar"
                                                                v-model="data.note"></vue-editor>
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
    props: ['date_selected'],
    data() {
        return {
            data: [],
            content: '',
            type: 5,
            date: '',
            lang: 'sr',
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
        modalShow() {
            this.$modal.show('show-trial-modal');
        },
        beforeOpenShow(event) {
            this.data = JSON.parse(JSON.stringify(event.params.data)) ;
        },
        closeModal() {
            this.$modal.hide('show-trial-modal');
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
