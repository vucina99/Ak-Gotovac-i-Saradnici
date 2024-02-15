<template>
    <div>
        <div class="options-first options-first-lg  ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="choose-type">
                            <show-trial :date_selected="date_selected"></show-trial>
                            <edit-trial :date_selected="date_selected"  :institutions_serchData="institutionsSerchData"></edit-trial>
                            <div class="container">
                                <div class="row">
                                    <div
                                        class="type-div-size type-div-size-back  bg-blue text-light pt-2 pb-2 d-flex align-items-center justify-content-center border-light-full">
                                        <span>DATUM : {{ date_selected }}</span>
                                    </div>
                                    <div @click="backToCalendar()"
                                         class="type-div-size type-div-size-back bg-blue text-light pt-2 pb-2 d-flex align-items-center justify-content-center border-light-full">
                                        <span><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> NAZAD </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 bg-personal-light">
                            <div class="container">
                                <div class="row">
                                    <div class=" col-12 col-lg-12 col-md-12 col-sm-12  pt-3 pb-3">

                                        <form action="">
                                            <div class="form-group search-font-size" v-if="type !== 6">
                                                <label>INSTITUCIJA</label>
                                                <v-select
                                                    :options="institutionsSerchData"
                                                    :id="'courts'"
                                                    label="name"
                                                    v-model="search.institution"
                                                    placeholder="INSTITUCIJA">
                                                </v-select>
                                            </div>


                                            <div class="form-group search-font-size">
                                                <label for="number_office">BROJ U KANCELARIJI</label>
                                                <input type="text" name="number_court" id="number_office"
                                                       class="form-control" v-model="search.number_office"
                                                       placeholder="BROJ U KANCELARIJI">
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="number_office">STRANKA 1</label>

                                                <v-select
                                                    :options="person_1_list"
                                                    :id="'prosecutor'"
                                                    label="prosecutor"
                                                    placeholder="STRANKA 1"
                                                    v-model="search.person_1">
                                                </v-select>
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="number_office">STRANKA 2</label>

                                                <v-select
                                                    :options="person_2_list"
                                                    :id="'defendants'"
                                                    v-model="search.person_2"
                                                    label="defendants"
                                                    placeholder="STRANKA 2">
                                                </v-select>
                                            </div>

                                            <div class="pb-3 search-font-size" hidden>
                                                <label for="fail_day">VREME</label>
                                                <div class="input-group custom-file-button">
                                                    <date-picker v-model="search.time" type="time"  format="HH:mm"
                                                                 id="fail_day" placeholder="VREME"></date-picker>
                                                </div>
                                            </div>

                                            <div class="pt-3">
                                                <div class="w-100 ">
                                                    <button class="btn btn-primary w-100" @click.prevent="getTrials()">
                                                        PRETRAGA <i class="fa fa-search" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="w-100 mt-3  " v-if="is_admin == 2" >
                                                    <add-trial :date_selected="date_selected"
                                                               :institutions_serchData="institutionsSerchData"></add-trial>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-8 col-sm-12 margin-top-table">

                        <div class="table-responsive">

                            <table class="table  table-hover table-text-size table-cursor">
                                <thead class="bg-blue text-personal-light">
                                <tr>
                                    <th></th>
                                    <th>VREME</th>
                                    <th>INSTITUCIJA</th>
                                    <th>BROJ SUDNICE</th>
                                    <th>STRANKA 1</th>
                                    <th>STRANKA 2</th>
                                    <th>BROJ U KANCELARIJI</th>
                                    <th>P BROJ</th>
                                    <th>ZAPOSLENI</th>
                                    <th>IZMENI</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(trial, index) in allTrial">
                                    <td @click.prevent="modalShowTrial(trial)"><i
                                        class="fa color-blue fa-arrow-circle-o-right" aria-hidden="true"></i></td>
                                    <td @click.prevent="modalShowTrial(trial)">
                                        {{ trial.time ? trial.time.slice(0, 5) : '' }}
                                    </td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.institution?.name }}</td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.courtroom_number }}</td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.prosecutor }}</td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.defendants }}</td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.numberOffice }}</td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.archive }}</td>
                                    <td @click.prevent="modalShowTrial(trial)">{{ trial.user?.name }}</td>
                                    <td @click.prevent="modalEditTrial(trial, index)">
                                        <div class="w-100" v-if="is_admin == 2"><i class="fa color-blue fa fa-pencil"  aria-hidden="true"></i>
                                        </div>
                                        <div class="w-100"  v-else><i class="fa text-danger fa-solid fa-ban" aria-hidden="true"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="allTrial.length < 1" class="bg-light">

                                    <td colspan="9" class="text-center">
                                        <vue-simple-spinner></vue-simple-spinner>
                                    </td>
                                </tr>
                                <tr v-if="!allTrial  " class="bg-light">

                                    <td colspan="10"
                                        class="text-center">
                                        <span>NEMA PODATAKA ZA PRIKAZ</span></td>

                                </tr>

                                </tbody>
                            </table>
                            <br>

                        </div>
                        <div class="paginationScroll" >
                            <nav aria-label="Page navigation example" class="w-100" v-if="paginateCount > 1 ">
                                <ul class="pagination ">
                                    <li v-if=" page !== 0" :class="[ page == 0 ? 'disabled' : '' ,  'page-item'  ]"
                                        @click.prevent="getTrials(page - 1)">
                                        <a class="page-link one" href="#" tabindex="-1"><i class="fa fa-chevron-left"
                                                                                           aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li v-for="index in paginateCount" :key="index"
                                        @click.prevent="getTrials(index-1)"
                                        :class="[page == index-1 ? 'active' : '' ,'page-item']"><a
                                        class="page-link number" href="#">{{ index }}</a></li>
                                    <li v-if=" page !== paginateCount - 1 "
                                        :class="[ page == paginateCount - 1 ? 'disabled' : '' ,  'page-item'  ]"
                                        @click.prevent="getTrials(page + 1)">
                                        <a class="page-link one" href="#"><i class="fa fa-chevron-right"
                                                                             aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vSelect from "vue-select";
import DatePicker from "vue2-datepicker";
import 'vue2-datepicker/locale/sr';
import AddTrial from "./AddTrial";
import EditTrial from "./EditTrial";
import ShowTrial from "./ShowTrial";


export default {
    name: "DateResults",
    props: ['date_selected' , 'is_admin'],
    components: {
        'v-select': vSelect,
        DatePicker,
        'add-trial': AddTrial,
        'edit-trial': EditTrial,
        'show-trial': ShowTrial
    },

    data() {
        return {
            type: 1,
            institutionsSerchData: [],
            allTrial: [],
            page: 0,
            person_1_list: [],
            person_2_list: [],
            paginateCount: 0,
            search: {
                institution: '',
                time: '',
                number_office: '',
                person_1: '',
                person_2: ''
            }
        }
    },
    methods: {
        getTrials(page = 0) {
            this.allCases = []

            if (this.search.number_office.trim().length === 0) {
                this.search.number_office = ''
            }
            if (page >= 0 && page <= this.paginateCount) {
                this.page = page
                axios.post('/trial/get/trials', {
                    'search': this.search,
                    'page': this.page,
                    'selected_date': this.date_selected
                }).then(({data}) => {
                    this.allTrial = data.data
                    this.paginateCount = data.count
                    if (this.allTrial.length < 1) {
                        this.allTrial = false
                    }
                }).catch((error) => {
                    alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
                })
            }
        },
        backToCalendar() {
            window.location.href = "/trial";
        },
        modalShowTrial(data) {

            this.$modal.show('show-trial-modal', {'data': data});
        },
        modalEditTrial(data , index) {
            if(this.is_admin == 2){
                this.$modal.show('edit-trial-modal', {'data': data , 'index' : index});
            }
        },
        getInstitutionsForSearch() {
            axios.get('/trial/get/institutions').then(({data}) => {
                this.institutionsSerchData = data;
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        },
        getPersons() {
            axios.post('/trial/get/persons', {'selected_date': this.date_selected}).then(({data}) => {

                this.person_1_list = data.person_1_list;
                this.person_2_list = data.person_2_list;
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        },
    },
    created() {
        this.getTrials();
        this.getInstitutionsForSearch();
        this.getPersons()

        this.$root.$on("addEditedTrialInArray", (data) => {
            if (typeof this.allTrial[data.trialIndex] !== "undefined") {
                this.allTrial = this.allTrial.map((x, indexMap) => (data.trialIndex === indexMap) ? data.trialData : x)
                this.getInstitutionsForSearch();
                this.getPersons()

            }
        })

        this.$root.$on("removeTrialFromArray", (trialIndex) => {
            if (typeof this.allTrial[trialIndex] !== "undefined") {

                this.allTrial.splice(trialIndex, 1);
                if( this.allTrial.length < 1){
                    this.allTrial = false;
                }
            }
        })

        this.$root.$on("addNewTrialInArray", (data) => {
            if (this.allTrial == false) {
                this.allTrial = []
            }
            this.allTrial.push(data)
        })
    }
}
</script>

<style scoped>
@import 'vue2-datepicker/index.css';
@import "vue-select/dist/vue-select.css";
@import "/public/css/style.css";
@import "/public/css/responsive.css";
</style>
