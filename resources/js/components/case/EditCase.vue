<template>
    <div>
        <modal :name="'edit-case-modal'" @before-open="beforeOpenEdit" :shiftY="0.1" :scrollable="true" :adaptive="true"
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
                                            <vue-confirm-dialog></vue-confirm-dialog>
                                            <div class="w-100" v-if="caseData == null || loader">
                                                <vue-simple-spinner></vue-simple-spinner>
                                                <br>
                                            </div>
                                            <div v-if="success && !loader"
                                                 class="alert error-danger alert-success alert-dismissible fade show"
                                                 role="alert">
                                                <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; SLUĆAJ JE USPEŠNO IZMENJEN</span>
                                                <button @click.prevent="success = false" type="button" class="close"

                                                >
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="post" class="add-form-modal text-left"
                                                  v-if="caseData !== null " :hidden="loader">
                                                <div class="form-group search-font-size-modal" v-if="type !== 6">
                                                    <label v-if="type == 1">SUD</label>
                                                    <label v-if="type == 2">SUD / TUŽILAŠTVO</label>
                                                    <label v-if="type == 3">SUD</label>
                                                    <label v-if="type == 4">SUD / IZVRŠITELJ</label>
                                                    <label v-if="type == 5">OSIGURANJE</label>

                                                    <v-select
                                                        :options="institutionsSerchData"
                                                        :id="'courts'"
                                                        label="name"
                                                        v-model="caseData.institution"
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
                                                           id="number_court"
                                                           v-model="caseData.numberOffice"
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
                                                           id="number_office"
                                                           v-model="caseData.numberInstitution"
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
                                                           v-model="caseData.archive " id="archiva"
                                                           :placeholder="'ARHIVSKI BROJ'">
                                                </div>


                                                <div class="form-group ">

                                                    <label v-if="type == 1" for="number_office">TUŽILAC</label>
                                                    <label v-if="type == 2" for="number_office">OŠTEĆENI</label>
                                                    <label v-if="type == 3" for="number_office">OKRIVLJENI</label>
                                                    <label v-if="type == 4" for="number_office">IZVRŠNI
                                                        POVERILAC </label>
                                                    <label v-if="type == 5" for="number_office">OŠTEĆENI</label>
                                                    <label v-if="type == 6" for="number_office">STRANKA</label>
                                                    <input type="text" class="form-control"
                                                           id="prosecutor"
                                                           v-model="caseData.prosecutor"
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
                                                    <label v-if="type == 1" for="number_office">TUŽENI</label>
                                                    <label v-if="type == 2" for="number_office">OKRIVLJENI</label>
                                                    <label v-if="type == 4" for="number_office">IZVRŠNI DUŻNIK </label>
                                                    <label v-if="type == 5" for="number_office">ŠTETNIK</label>

                                                    <input type="text" class="form-control"
                                                           id="defendants"
                                                           v-model="caseData.defendants"
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
                                                        <date-picker  v-model="caseData.failDay"
                                                                     id="fail_day"
                                                                     :placeholder="caseData.failDay ? JSON.stringify(caseData.failDay)  : 'DAN NASTANKA NEZGODE'"></date-picker>
                                                    </div>
                                                </div>

                                                <div class="form-group " v-if="type == 5">

                                                    <label for="marks">REGISTASKE OZNAKE</label>

                                                    <input type="text" v-model="caseData.mark"
                                                           class="form-control" id="marks"
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
                                                    <vue-editor id="notes"
                                                                :editorToolbar="customToolbar"
                                                                v-model="caseData.note"></vue-editor>
                                                </div>
                                                <table
                                                    class="table mt-4  table-hover table-text-size table-cursor border-right-black">
                                                    <thead class="bg-blue text-personal-light">
                                                    <tr>
                                                        <th>IME FAJLA</th>
                                                        <th>DATUM</th>
                                                        <th>FAJL</th>
                                                        <th>OBRIŠI</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr class="bg-white " v-for="(file , key) in fileData" :key="key">
                                                        <td class="pb-0">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" v-model="file.path"  @keypress.enter="changeFilePath(file.id , file.path)">
                                                            </div>
                                                        </td>
                                                        <td>{{ file.date }}</td>
                                                        <td>
                                                            <a :href="file.name" download="" target="_blank" rel="noopener noreferrer">
                                                                <i class="fa text-dark fa-file-text file-small-text"
                                                                   aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td @click.prevent="removeFile(file.id , key)">
                                                            <i class="fa fa-trash text-danger file-small-text"
                                                               aria-hidden="true"></i>
                                                        </td>
                                                    </tr>
                                                    <td v-if="fileData.length < 1" colspan="4"
                                                        class="text-center bg-light">
                                                        <span>NEMA PODATAKA ZA PRIKAZ</span>
                                                    </td>

                                                    </tbody>
                                                </table>

                                                <div class="pb-1 pt-4">
                                                    <button class="btn btn-primary w-100" @click.prevent="editCase()">
                                                        IZMENI SLUČAJ &nbsp; <i
                                                        class="fa fa-spinner" aria-hidden="true"></i>
                                                    </button>
                                                </div>


                                                <div class="pb-4 pt-4">
                                                    <button class="btn btn-danger w-100" @click.prevent="deleteCase()">
                                                        OBRIŠI CEO SLUČAJ &nbsp; <i
                                                        class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <br>
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
    name: "EditCase",
    props: ['type', 'case_types', 'institutionsSerchData'],
    data() {
        return {
            loader: true,
            data: [],
            caseID: '',
            caseData: null,
            fileData: [],
            caseIndex: -1,
            success: false,
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

    mounted(){
        this.loader = true;
        this.success = false;

    },
    methods: {
        changeFilePath(id, path){
            this.success = false;
            this.loader = true;
            axios.patch('/case/edit-file-path/' + id, {"path": path}).then(({data}) => {
                this.getCase();
                this.success= true;
            }).catch((error) => {
                alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
            })
        },
        deleteCase() {


            this.$confirm({
                message: 'DA LI STE SIGURNI DA ŽELITE DA OBRIŠETE SLUČAJ?',
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
                        this.loader = true;
                        axios.delete('/case/delete/case/' + this.caseID).then(({data}) => {


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
                                        this.$root.$emit('removeCaseFromArray', this.caseIndex);
                                        this.loader = false;
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

        editCase() {
            this.loader = true;
            this.success= false;
            axios.patch('/case/edit/' + this.caseID, this.caseData).then(({data}) => {


                let case_id = data.id
                const formData = new FormData();
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
                        'case_id': this.caseID
                    }).then(({data}) => {
                        this.getCase();
                        this.$root.$emit('addEditedCaseInArray', {'caseData': this.caseData, 'caseIndex': this.caseIndex});
                        this.success= true;
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
        removeFile(fileId, index) {


            this.$confirm({
                message: 'DA LI STE SIGURNI DA ŽELITE DA OBRIŠETE FAJL?',
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
                        this.loader = true;
                        axios.delete('case/remove/file/' + fileId).then(({data}) => {
                            const filter = this.fileData.filter((value, key) => {
                                return key !== index
                            });
                            this.fileData = filter;
                            this.loader = false;
                        }).catch((error) => {
                            alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
                        });
                    }
                }
            })
        },


        getCase() {

            axios.get('/case/get/case/' + this.caseID).then(({data}) => {
                this.caseData = data.case
                this.caseData['case_type_id'] = this.type
                this.fileData = data.caseFiles
                this.loader = false;
                console.log( data.case);
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        },
        beforeOpenEdit(event) {
            this.caseID = event.params.caseID;
            this.caseIndex = event.params.caseIndex;
            this.loader = true;
            this.success = false;
            this.getCase();
        },
        closeModal() {
            this.$modal.hide('edit-case-modal');
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

