<template>
    <div>
        <button class="btn btn-success w-100" @click.prevent="modalShow()">
            DODAJ <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <modal name="add-case-modal" :shiftY="0.1" :scrollable="true" :adaptive="true" :resizable="true" height="auto">
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-4  d-flex justify-content-end w-100 ">
                        <div class="text-right w-25 " @click="closeModal()">
                            <i class="fa fa-times fa-2x text-muted" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-type choose-type">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="choose-type w-100">
                                <div class="container"><br>
                                    <div class="row">
                                        <div v-for="(caseType, index) in case_types"
                                             :class="[ 'type-div-size bg-personal-light pt-2 pb-2 d-flex align-items-center justify-content-center border-light-full' , caseType.id == type ? 'bg-blue text-light' : '',]">
                                            <span>{{ caseType.name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="container bg-personal-light">
                                    <div class="row">
                                        <div class="col-12"><br>
                                            <div class="w-100" v-if="loader">
                                                <vue-simple-spinner></vue-simple-spinner>
                                                <br>
                                            </div>
                                            <div v-if="success && !loader"
                                                 class="alert error-danger alert-success alert-dismissible fade show"
                                                 role="alert">
                                                <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; SLUĆAJ JE USPEŠNO DODAT</span>
                                                <button @click.prevent="success = false" type="button" class="close"

                                                >
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="post" class="add-form-modal " :hidden="loader"
                                                  enctype="multipart/form-data">
                                                <div class="form-group search-font-size-modal " v-if="type !== 6">
                                                    <label v-if="type == 1">SUD</label>
                                                    <label v-if="type == 2">SUD / TUŽILAŠTVO</label>
                                                    <label v-if="type == 3">SUD</label>
                                                    <label v-if="type == 4">SUD / IZVRŠITELJ</label>
                                                    <label v-if="type == 5">OSIGURANJE</label>

                                                    <v-select
                                                        :options="institutionsSerchData"
                                                        :id="'courts'"
                                                        label="name"
                                                        v-model="dataCase.institutions"
                                                        :placeholder="
                                                        type == 1 ? 'SUD' :
                                                        type == 2 ? 'SUD / TUŽILAŠTVO' :
                                                        type == 3   ? 'SUD' :
                                                        type == 4 ? 'SUD / IZVRŠITELJ' :
                                                        type == 5 ? 'OSIGURANJE' : ''">
                                                    </v-select>
                                                </div>


                                                <div class="form-group">
                                                    <label for="number_court">BROJ U KANCELARIJI</label>
                                                    <input type="text" class="form-control"
                                                           v-model="dataCase.number_office" id="number_court"
                                                           placeholder="BROJ U KANCELARIJI">
                                                </div>
                                                <div class="form-group">
                                                    <label v-if="type == 1" for="number_office">BROJ U SUDU</label>
                                                    <label v-if="type == 2" for="number_office">BROJ U
                                                        SUDU/TUŽILAŠTVU</label>
                                                    <label v-if="type == 3" for="number_office">BROJ U SUDU</label>
                                                    <label v-if="type == 4" for="number_office">BROJ U SUDU / KOD
                                                        IZVRŠITELJA </label>
                                                    <label v-if="type == 5" for="number_office">BROJ U
                                                        OSIGURANJU</label>
                                                    <label v-if="type == 6" for="number_office">P BROJ</label>

                                                    <input type="text" class="form-control"
                                                           v-model="dataCase.number_court " id="number_office"
                                                           :placeholder="
                                                        type == 1 ? 'BROJ U SUDU' :
                                                        type == 2 ? 'BROJ U SUDU/TUŽILAŠTVU' :
                                                        type == 3   ? 'BROJ U SUDU'  :
                                                        type == 4 ? 'BROJ  U SUDU  /  KOD IZVRŠITELJA ' :
                                                        type == 5 ? 'BROJ U OSIGURANJU' :
                                                        type == 6 ? 'P BROJ' : ''">
                                                </div>



                                                <div class="form-group"  v-if="type == 6">
                                                    <label  for="archiva">ARHIVSKI BROJ</label>
                                                    <input type="text" class="form-control"
                                                           v-model="dataCase.archive " id="archiva"
                                                           :placeholder="'ARHIVSKI BROJ'">
                                                </div>



                                                <div class="form-group ">

                                                    <label v-if="type == 1" for="prosecutor">TUŽILAC</label>
                                                    <label v-if="type == 2" for="prosecutor">OŠTEĆENI</label>
                                                    <label v-if="type == 3" for="prosecutor">OKRIVLJENI</label>
                                                    <label v-if="type == 4" for="prosecutor">IZVRŠNI
                                                        POVERILAC </label>
                                                    <label v-if="type == 5" for="prosecutor">OŠTEĆENI</label>
                                                    <label v-if="type == 6" for="prosecutor">STRANKA</label>
                                                    <input type="text" class="form-control"
                                                           v-model="dataCase.prosecutor" id="prosecutor"
                                                           :placeholder="
                                                        type == 1 ? 'TUŽILAC' :
                                                        type == 2 ? 'OŠTEĆENI' :
                                                        type == 3   ? 'OKRIVLJENI'  :
                                                        type == 4 ? 'IZVRŠNI POVERILAC ' :
                                                        type == 5 ? 'OŠTEĆENI' :
                                                        type == 6 ? 'STRANKA' : ''">
                                                </div>
                                                <div class="form-group"
                                                     v-if="type == 1 || type == 2 || type == 4 || type == 5  ">
                                                    <label v-if="type == 1" for="defendants">TUŽENI</label>
                                                    <label v-if="type == 2" for="defendants">OKRIVLJENI</label>
                                                    <label v-if="type == 4" for="defendants">IZVRŠNI DUŻNIK </label>
                                                    <label v-if="type == 5" for="defendants">ŠTETNIK</label>

                                                    <input type="text" class="form-control"
                                                           v-model="dataCase.defendants" id="defendants"
                                                           :placeholder="
                                                        type == 1 ? 'TUŽENI' :
                                                        type == 2 ? 'OKRIVLJENI' :
                                                        type == 4 ? 'IZVRŠNI DUŻNIK' :
                                                        type == 5 ? 'ŠTETNIK' :''"
                                                    >
                                                </div>
                                                <div class="pb-3" v-if="type == 5">
                                                    <label for="fail_day">DAN NASTANKA NEZGODE</label>
                                                    <div class="input-group custom-file-button">
                                                        <date-picker id="fail_day" v-model="dataCase.fail_day"
                                                                     placeholder="DAN NASTANKA NEZGODE"></date-picker>
                                                    </div>
                                                </div>

                                                <div class="form-group " v-if="type == 5">

                                                    <label for="marks">REGISTASKE OZNAKE</label>

                                                    <input type="text" v-model="dataCase.marks" class="form-control"
                                                           id="marks"
                                                           placeholder="REGISTASKE OZNAKE">
                                                </div>

                                                <div class="pb-3">
                                                    <label>DOKUMENTI</label>
                                                    <div class="input-group custom-file-button">
                                                        <span class="input-group-text "><i class="fa fa-search-plus"
                                                                                           aria-hidden="true"></i></span>
                                                        <input type="file" multiple ref="file" class="form-control"
                                                               id="inputGroupFile">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="notes">BELEŠKA</label>
                                                    <vue-editor id="notes" v-model="dataCase.notes"
                                                                :editorToolbar="customToolbar"
                                                    ></vue-editor>
                                                </div>


                                                <div class="pb-4 pt-4">
                                                    <button class="btn btn-primary w-100" @click.prevent="addCase()">
                                                        DODAJ SLUČAJ &nbsp; <i
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

            <button type="button" hidden="hidden" class="btn btn-primary" ref="showAllNames" data-bs-toggle="modal" data-bs-target="#exampleModal">
                sakriveno dugme
            </button>



        </modal>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalLabel">Već postojeći nazivi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-for="(name, index) in allSimilarNames">
                            <p class="text-center p-0" style="font-size: 14px !important;">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" ref="closeModal" data-bs-dismiss="modal" hidden="hidden">Close</button>
                        <button type="button" @click="addNewCase()" class="btn btn-primary">Sačuvaj</button>
                        <button type="button" @click="cancelNewCase()" class="btn btn-danger">Odustani</button>

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>

import vSelect from "vue-select";
import {VueEditor} from "vue2-editor";
import DatePicker from 'vue2-datepicker';


export default {
    name: "AddCase",
    props: ['type', 'case_types', 'institutionsSerchData'],
    data() {
        return {
            loader: false,
            data: [],
            lang: 'sr',
            files: '',
            success: false,
            allSimilarNames : [],
            dataCase: {
                'institutions': '',
                'number_court': '',
                'number_office': '',
                'prosecutor': '',
                'defendants': '',
                'fail_day': '',
                'marks': '',
                'notes': '',
                'archive': '',
                'case_type_id': this.type,


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
    watch: {
        type() {
            this.dataCase.case_type_id = this.type;
        }
    },
    methods: {
        cancelNewCase(){
            this.loader = false
            this.$refs.closeModal.click();
            this.success = false
        },
        addCase() {

            this.loader = true
            this.success = false
            axios.post('/case/check/existing/name', this.dataCase).then(({data}) => {
                if(data.allNames.length > 0){
                    this.allSimilarNames = data.allNames;
                    this.$refs.showAllNames.click();
                }else{
                    this.allSimilarNames = [];
                    this.addNewCase();
                }
                this.loader = false

            }).catch((error) => {
                this.cancelNewCase();
                alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
            })
        },
        addNewCase(){
            this.loader = true
            this.success = false
            axios.post('/case/create/case', this.dataCase).then(({data}) => {
                this.$refs.closeModal.click();
                this.success = true;
                this.dataCase = {
                    'institutions': '',
                    'number_court': '',
                    'number_office': '',
                    'prosecutor': '',
                    'defendants': '',
                    'fail_day': '',
                    'marks': '',
                    'notes': '',
                    'case_type_id': this.type,
                }
                let case_id = data.id
                const formData = new FormData();
                this.$root.$emit("addNewCaseInArray", data);
                for (var i = 0; i < this.$refs.file.files.length; i++) {
                    let file = this.$refs.file.files[i];
                    formData.append('files[' + i + ']', file);
                }

                axios.post('/case/files/upload', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                    }
                ).then(({data}) => {

                    axios.post('/case/update/files', {
                        'dataUploadedID': data.ids,
                        'case_id': case_id
                    }).then(({data}) => {
                            this.loader = false
                    })
                        .catch((error) => {
                            alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
                        });

                })
                    .catch((error) => {
                    });

            }).catch((error) => {
                alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
            })
        },
        modalShow() {
            this.success = false
            this.dataCase = {
                'institutions': '',
                'number_court': '',
                'number_office': '',
                'prosecutor': '',
                'defendants': '',
                'fail_day': '',
                'marks': '',
                'notes': '',
                'case_type_id': this.type,
            }
            this.$modal.show('add-case-modal');
        },
        closeModal() {
            this.$modal.hide('add-case-modal');
        }
    },

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
