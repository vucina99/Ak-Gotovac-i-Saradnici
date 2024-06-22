<template>
    <div class="options-first options-first-lg  ">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <show-case :type="type" :case_types="caseTypes"></show-case>
                    <edit-case :type="type" :case_types="caseTypes"
                               :institutionsSerchData="institutionsSerchData"></edit-case>
                    <div class="choose-type">
                        <div class="container">
                            <div class="row">
                                <div v-for="(caseType, index) in caseTypes" @click.prevent="type = caseType.id"
                                     :class="[ 'type-div-size bg-personal-light pt-2 pb-2 d-flex align-items-center justify-content-center border-light-full' , caseType.id == type ? 'bg-blue text-light' : '',]">
                                    <span>{{ caseType.name }}</span>
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
                                            <label v-if="type == 1">SUD</label>
                                            <label v-if="type == 2">SUD / TUŽILAŠTVO</label>
                                            <label v-if="type == 3">SUD</label>
                                            <label v-if="type == 4">SUD / IZVRŠITELJ</label>
                                            <label v-if="type == 5">OSIGURANJE</label>
                                            <v-select
                                                :options="institutionsSerchData"
                                                :id="'courts'"
                                                label="name"
                                                v-model="search.institution"
                                                :placeholder="
                                                        type == 1 ? 'SUD' :
                                                        type == 2 ? 'SUD / TUŽILAŠTVO' :
                                                        type == 3   ? 'SUD' :
                                                        type == 4 ? 'SUD / IZVRŠITELJ' :
                                                        type == 5 ? 'OSIGURANJE' : ''">
                                            </v-select>
                                        </div>
                                        <div class="form-group search-font-size">
                                            <label v-if="type == 1" for="number_office">BROJ U SUDU</label>
                                            <label v-if="type == 2" for="number_office">BROJ U SUDU/TUŽILAŠTVU</label>
                                            <label v-if="type == 3" for="number_office">BROJ U SUDU</label>
                                            <label v-if="type == 4" for="number_office">BROJ U SUDU / KOD
                                                IZVRŠITELJA </label>
                                            <label v-if="type == 5" for="number_office">BROJ U OSIGURANJU</label>
                                            <label v-if="type == 6" for="number_office">P BROJ</label>
                                            <input type="text" name="number_court" id="number_court"
                                                   v-model="search.institution_number"
                                                   class="form-control" :placeholder="
                                                        type == 1 ? 'BROJ U SUDU' :
                                                        type == 2 ? 'BROJ U SUDU/TUŽILAŠTVU' :
                                                        type == 3   ? 'BROJ U SUDU'  :
                                                        type == 4 ? 'BROJ  U SUDU  /  KOD IZVRŠITELJA ' :
                                                        type == 5 ? 'BROJ U OSIGURANJU' :
                                                        type == 6 ? 'P BROJ' : ''">
                                        </div>

                                        <div class="form-group search-font-size">
                                            <label for="number_office">BROJ U KANCELARIJI</label>
                                            <input type="text" name="number_court" v-model="search.number_office"
                                                   id="number_office"
                                                   class="form-control" placeholder="BROJ U KANCELARIJI">
                                        </div>

                                        <div class="form-group search-font-size">
                                            <label v-if="type == 1" for="number_office">TUŽILAC</label>
                                            <label v-if="type == 2" for="number_office">OŠTEĆENI</label>
                                            <label v-if="type == 3" for="number_office">OKRIVLJENI</label>
                                            <label v-if="type == 4" for="number_office">IZVRŠNI POVERILAC </label>
                                            <label v-if="type == 5" for="number_office">OŠTEĆENI</label>
                                            <label v-if="type == 6" for="number_office">STRANKA</label>
                                            <v-select
                                                :options="person_1_list"
                                                :id="'prosecutor'"
                                                label="prosecutor"
                                                v-model="search.person_1"
                                                :placeholder="
                                                        type == 1 ? 'TUŽILAC' :
                                                        type == 2 ? 'OŠTEĆENI' :
                                                        type == 3   ? 'OKRIVLJENI'  :
                                                        type == 4 ? 'IZVRŠNI POVERILAC ' :
                                                        type == 5 ? 'OŠTEĆENI' :
                                                        type == 6 ? 'STRANKA' : ''">
                                            </v-select>
                                        </div>
                                        <div class="form-group search-font-size"
                                             v-if="type == 1 || type == 2 || type == 4 || type == 5  ">
                                            <label v-if="type == 1" for="number_office">TUŽENI</label>
                                            <label v-if="type == 2" for="number_office">OKRIVLJENI</label>
                                            <label v-if="type == 4" for="number_office">IZVRŠNI DUŻNIK </label>
                                            <label v-if="type == 5" for="number_office">ŠTETNIK</label>
                                            <v-select
                                                :options="person_2_list"
                                                :id="'defendants'"
                                                label="defendants"
                                                v-model="search.person_2"
                                                :placeholder="
                                                        type == 1 ? 'TUŽENI' :
                                                        type == 2 ? 'OKRIVLJENI' :
                                                        type == 4 ? 'IZVRŠNI DUŻNIK' :
                                                        type == 5 ? 'ŠTETNIK' :''">
                                            </v-select>
                                        </div>




                                        <div class="form-group search-font-size" v-if="type == 6">

                                            <label  for="archive_number">ARHIVSKI BROJ</label>
                                            <input type="text" name="archive_number" id="archive_number"
                                                   v-model="search.archive"
                                                   class="form-control" placeholder="ARHIVSKI BROJ">
                                        </div>

                                        <div class="pt-3">
                                            <div class="w-100 d-flex justify-content-between">
                                                <button class="btn btn-primary w-50 mr-1" @click.prevent="getCase()">
                                                    PRETRAGA <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-primary ml-1 w-50"
                                                        @click.prevent="resetFilter()">
                                                    RESETUJ <i class="fa fa-refresh" aria-hidden="true"></i>

                                                </button>
                                            </div>
                                            <div class="w-100 mt-3  " v-if="is_admin == 2">
                                                <add-cases :type="type" :institutionsSerchData="institutionsSerchData"
                                                           :case_types="caseTypes"></add-cases>
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
                                <th scope="col">BROJ U KANCELARIJI</th>
                                <th scope="col">
                                    <span v-if="type == 1">BROJ U SUDU</span>
                                    <span v-if="type == 2">BROJ U SUDU/TUŽILAŠTVU</span>
                                    <span v-if="type == 3">BROJ U SUDU</span>
                                    <span v-if="type == 4">BROJ  U SUDU  /  KOD IZVRŠITELJA </span>
                                    <span v-if="type == 5">BROJ U OSIGURANJU</span>
                                    <span v-if="type == 6">P BROJ</span>
                                </th>
                                <th v-if="type == 6  ">
                                    ARHIVSKI BROJ
                                </th>
                                <th scope="col">
                                    <span v-if="type == 1">TUŽILAC</span>
                                    <span v-if="type == 2">OŠTEĆENI</span>
                                    <span v-if="type == 3">OKRIVLJENI</span>
                                    <span v-if="type == 4">IZVRŠNI POVERILAC </span>
                                    <span v-if="type == 5">OŠTEĆENI</span>
                                    <span v-if="type == 6">STRANKA</span>
                                </th>
                                <th scope="col" v-if="type == 1 || type == 2 || type == 4 || type == 5  ">
                                    <span v-if="type == 1">TUŽENI</span>
                                    <span v-if="type == 2">OKRIVLJENI</span>
                                    <span v-if="type == 4">IZVRŠNI DUŻNIK </span>
                                    <span v-if="type == 5">ŠTETNIK</span>
                                </th>
                                <th scope="col" v-if="type !== 6">
                                    <span v-if="type == 1">SUD</span>
                                    <span v-if="type == 2">SUD / TUŽILAŠTVO</span>
                                    <span v-if="type == 3">SUD</span>
                                    <span v-if="type == 4">SUD / IZVRŠITELJ</span>
                                    <span v-if="type == 5">OSIGURANJE</span>
                                </th>
                                <th scope="col">IZMENI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(data, index) in allCases" :key="index">
                                <td @click.prevent="modalShowCase(data.id)"><i
                                    class="fa color-blue fa-arrow-circle-o-right"
                                    aria-hidden="true"></i></td>
                                <td @click.prevent="modalShowCase(data.id)">{{ data.numberOffice }}</td>
                                <td @click.prevent="modalShowCase(data.id)">{{ data.numberInstitution }}</td>
                                <td @click.prevent="modalShowCase(data.id)" v-if="type == 6">{{ data.archive }}</td>
                                <td @click.prevent="modalShowCase(data.id)">{{ data.prosecutor }}</td>
                                <td v-if="type == 1 || type == 2 || type == 4 || type == 5  "
                                    @click.prevent="modalShowCase(data.id)">{{ data.defendants }}
                                </td>
                                <td v-if="type !== 6" @click.prevent="modalShowCase(data.id)">{{
                                        data.institution?.name
                                    }}
                                </td>
                                <td @click.prevent="modalEditCase(data.id , index)">
                                    <div class="w-100" v-if="is_admin == 2"><i class="fa color-blue fa fa-pencil" aria-hidden="true"></i>
                                    </div>
                                    <div class="w-100"  v-else><i class="fa text-danger fa-solid fa-ban" aria-hidden="true"></i>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="allCases.length < 1" class="bg-light">
                                <td v-if="type == 1 || type == 2 || type == 4 || type == 5 " colspan="7"
                                    class="text-center">
                                    <vue-simple-spinner></vue-simple-spinner>
                                </td>
                                <td v-if="type == 3  " colspan="6" class="text-center">
                                    <vue-simple-spinner></vue-simple-spinner>
                                </td>
                                <td v-if="type == 6  " colspan="6" class="text-center">
                                    <vue-simple-spinner></vue-simple-spinner>
                                </td>
                            </tr>
                            <tr v-if="!allCases  " class="bg-light">

                                <td v-if="type == 1 || type == 2 || type == 4 || type == 5 " colspan="7"
                                    class="text-center">
                                    <span>NEMA PODATAKA ZA PRIKAZ</span></td>
                                <td v-if="type == 3  " colspan="6" class="text-center">
                                    <span>NEMA PODATAKA ZA PRIKAZ</span></td>
                                <td v-if="type == 6  " colspan="6" class="text-center">
                                    <span>NEMA PODATAKA ZA PRIKAZ</span></td>
                            </tr>


                            </tbody>
                        </table>


                    </div>
                    <br>
                    <div class="paginationScroll" >
                    <nav aria-label="Page navigation example" class="w-100" v-if="paginateCount > 1 ">
                        <ul class="pagination ">
                            <li v-if=" page !== 0" :class="[ page == 0 ? 'disabled' : '' ,  'page-item'  ]"
                                @click.prevent="getCase(page - 1)">
                                <a class="page-link one" href="#" tabindex="-1"><i class="fa fa-chevron-left"
                                                                                   aria-hidden="true"></i>
                                </a>
                            </li>
                            <li v-for="index in paginateCount" :key="index"
                                @click.prevent="getCase(index-1)"
                                :class="[page == index-1 ? 'active' : '' ,'page-item']"><a
                                class="page-link number" href="#">{{ index }}</a></li>
                            <li v-if=" page !== paginateCount - 1 "
                                :class="[ page == paginateCount - 1 ? 'disabled' : '' ,  'page-item'  ]"
                                @click.prevent="getCase(page + 1)">
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
</template>

<script>
import vSelect from "vue-select";
import AddCase from "./AddCase";
import EditCase from "./EditCase";
import ShowCase from "./ShowCase";
import 'vue2-datepicker/locale/sr';

export default {
    name: "SearchResult",
    props:["is_admin"],
    components: {
        'v-select': vSelect,
        'add-cases': AddCase,
        'edit-case': EditCase,
        'show-case': ShowCase
    },
    data() {
        return {
            institutionsSerchData: [],
            type: 1,
            allCases: [],
            caseTypes: [],
            page: 0,
            paginateCount: 0,
            institutionsType: [1],
            person_1_list: [],
            person_2_list: [],
            search: {
                institution: '',
                institution_number: '',
                number_office: '',
                person_1: '',
                person_2: '',
                archive: ''
            }
        }
    },
    watch: {

        type: {
            handler: function (val, oldVal) {
                this.changesAfterChangingType(); // call it in the context of your component object
            },
            deep: true

        }
    },
    methods: {
        resetFilter() {
            this.search = {
                institution: '',
                institution_number: '',
                number_office: '',
                person_1: '',
                person_2: '',
                archive: ''
            }
        },
        getPersons() {
            axios.post('/case/get/persons', {'case_type_id': this.type}).then(({data}) => {

                this.person_1_list = data.person_1_list;
                this.person_2_list = data.person_2_list;
                console.log(data)
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        },
        getInstitutionsForSearch() {
            axios.post('/case/get/institutions', {'institutionsType': this.institutionsType}).then(({data}) => {
                this.institutionsSerchData = data;
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        },
        getCase(page = 0) {
            this.allCases = []
            if (this.search.institution_number.trim().length === 0) {
                this.search.institution_number = ''
            }
            if (this.search.number_office.trim().length === 0) {
                this.search.number_office = ''
            }
            if (page >= 0 && page <= this.paginateCount) {
                this.page = page
                axios.post('/case/get/cases', {
                    'search': this.search,
                    'page': this.page,
                    'caseType': this.type
                }).then(({data}) => {
                    this.allCases = data.data
                    this.paginateCount = data.count
                    if (this.allCases.length < 1) {
                        this.allCases = false
                    }
                }).catch((error) => {
                    alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
                })
            }
        },
        changesAfterChangingType() {
            if (this.type == 1) {
                this.institutionsType = [1]
            } else if (this.type == 2) {
                this.institutionsType = [1, 2]
            } else if (this.type == 3) {
                this.institutionsType = [1]
            } else if (this.type == 4) {
                this.institutionsType = [1, 3]
            } else if (this.type == 5) {
                this.institutionsType = [4]
            } else if (this.type == 6) {
                this.institutionsType = []
            }
            this.search = {
                institution: '',
                institution_number: '',
                number_office: '',
                person_1: '',
                person_2: '',
                archive: ''
            }
            this.page = 0;
            this.getCase();
            this.getInstitutionsForSearch()
            this.getPersons();
        },
        modalShowCase(data) {

            this.$modal.show('show-case-modal', {'caseID': data});
        },

        modalEditCase(data, index) {
            if(this.is_admin == 2){
                this.$modal.show('edit-case-modal', {'caseID': data, 'caseIndex': index});

            }
        },
        getCaseType() {
            axios.get('/case/get/type').then(({data}) => {
                this.caseTypes = data
                console.log(data);
            })
        },
    },
    created() {
        this.getCaseType();
        this.getCase();
        this.getInstitutionsForSearch()
        this.getPersons();

        this.$root.$on("addNewCaseInArray", (data) => {
            if (this.allCases == false) {
                this.allCases = []
            }
            this.allCases.push(data)
        })

        this.$root.$on("addEditedCaseInArray", (data) => {
            if (typeof this.allCases[data.caseIndex] !== "undefined") {
                this.allCases = this.allCases.map((x, indexMap) => (data.caseIndex === indexMap) ? data.caseData : x)
                this.getInstitutionsForSearch();
                this.getPersons();
            }
        })

        this.$root.$on("removeCaseFromArray", (caseIndex) => {
            if (typeof this.allCases[caseIndex] !== "undefined") {

                this.allCases.splice(caseIndex, 1);
                if( this.allCases.length < 1){
                    this.allCases = false;
                }
            }
        })
    }
}
</script>

<style scoped>
@import "vue-select/dist/vue-select.css";
@import "/public/css/style.css";
@import "/public/css/responsive.css";

</style>
