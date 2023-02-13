<template>
    <div>
        <div class="options-first options-first-lg  ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="choose-type">
                            <show-trial :date_selected="date_selected"></show-trial>
                            <edit-trial :date_selected="date_selected"></edit-trial>
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
                                                <label >INSTITUCIJA</label>
                                                <v-select
                                                    :options="institutionsSerchData"
                                                    :id="'courts'"
                                                    label="name"
                                                    placeholder="INSTITUCIJA" >
                                                </v-select>
                                            </div>


                                            <div class="form-group search-font-size">
                                                <label for="number_office">BROJ U KANCELARIJI</label>
                                                <input type="text" name="number_court" id="number_office"
                                                       class="form-control" placeholder="BROJ U KANCELARIJI">
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="number_office">STRANKA 1</label>

                                                <v-select
                                                    :options="[]"
                                                    :id="'prosecutor'"
                                                    label="name"
                                                    placeholder="STRANKA 1">
                                                </v-select>
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="number_office">STRANKA 2</label>

                                                <v-select
                                                    :options="[]"
                                                    :id="'prosecuto2r'"
                                                    label="name"
                                                    placeholder="STRANKA 2">
                                                </v-select>
                                            </div>

                                            <div class="pb-3 search-font-size">
                                                <label for="fail_day">VREME</label>
                                                <div class="input-group custom-file-button">
                                                    <date-picker v-model="date"  type="time"  format="HH:mm" id="fail_day" placeholder="VREME"></date-picker>
                                                </div>
                                            </div>

                                            <div class="pt-3">
                                                <div class="w-100 ">
                                                    <button class="btn btn-primary w-100">
                                                        PRETRAGA <i class="fa fa-search" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="w-100 mt-3  ">
                                                    <add-trial :date_selected="date_selected" :institutions_serchData="institutionsSerchData"></add-trial>
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
                                <th>BROJ U KANCELARIJI</th>
                                <th>STRANKA 1</th>
                                <th>STRANKA 2</th>
                                <th>SUD</th>
                                <th>IZMENI</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td @click.prevent="modalShowCase(2)"><i class="fa color-blue fa-arrow-circle-o-right" aria-hidden="true"></i></td>
                                <td @click.prevent="modalShowTrial(2)">09:15</td>
                                <td  @click.prevent="modalShowTrial(2)">12345</td>
                                <td  @click.prevent="modalShowTrial(2)">Pera Perovicc</td>
                                <td  @click.prevent="modalShowTrial(2)">Mikica Mikanovic</td>
                                <td  @click.prevent="modalShowTrial(2)">Prvi ustavni sud u beogradu</td>
                                <td @click.prevent="modalEditTrial(5)"><div class="w-100"> <i class="fa color-blue fa fa-pencil"  aria-hidden="true"></i></div></td>
                            </tr>
                            <tr>
                                <td @click.prevent="modalShowCase(2)"><i class="fa color-blue fa-arrow-circle-o-right" aria-hidden="true"></i></td>
                                <td>09:15</td>
                                <td>12345</td>
                                <td>Pera Peric</td>
                                <td>Mikica Mikanovic</td>
                                <td>Prvi ustavni sud u beogradu</td>
                                <td @click.prevent="modalEditTrial(5)"><div class="w-100"> <i class="fa color-blue fa fa-pencil"  aria-hidden="true"></i></div></td>
                            </tr>
                            <tr>
                                <td @click.prevent="modalShowCase(2)"><i class="fa color-blue fa-arrow-circle-o-right" aria-hidden="true"></i></td>
                                <td>09:15</td>
                                <td>12345</td>
                                <td>Pera Peric</td>
                                <td>Mikica Mikanovic</td>
                                <td>Prvi ustavni sud u beogradu</td>
                                <td @click.prevent="modalEditTrial(5)"><div class="w-100"> <i class="fa color-blue fa fa-pencil"  aria-hidden="true"></i></div></td>
                            </tr>
                            <tr>
                                <td @click.prevent="modalShowCase(2)"><i class="fa color-blue fa-arrow-circle-o-right" aria-hidden="true"></i></td>
                                <td>09:15</td>
                                <td>12345</td>
                                <td>Pera Peric</td>
                                <td>Mikica Mikanovic</td>
                                <td>Prvi ustavni sud u beogradu</td>
                                <td @click.prevent="modalEditTrial(5)"><div class="w-100"> <i class="fa color-blue fa fa-pencil"  aria-hidden="true"></i></div></td>
                            </tr>

                            </tbody>
                        </table>
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
    props:['date_selected'],
    components: {
        'v-select': vSelect,
        DatePicker,
        'add-trial' : AddTrial,
        'edit-trial' : EditTrial,
        'show-trial' : ShowTrial
    },

    data(){
        return {
            type : 1,
            date: '',
            institutionsSerchData: [],
        }
    },
    methods : {
        backToCalendar(){
            window.location.href = "/trial";
        },
        modalShowTrial(data) {

            this.$modal.show('show-trial-modal' , {'propType'  :data} );
        },
        modalEditTrial(data) {
            this.$modal.show('edit-trial-modal', {'propType'  :data} );
        },
        getInstitutionsForSearch() {
            axios.get('/trial/get/institutions').then(({data}) => {
                this.institutionsSerchData = data;
            }).catch((error) => {
                alert('Došlo je do greške, probajte ponovo ili kontaktirajte administratora')
            })
        }
    },
    created() {
        this.getInstitutionsForSearch();
    }
}
</script>

<style scoped>
@import 'vue2-datepicker/index.css';
@import "vue-select/dist/vue-select.css";
@import "/public/css/style.css";
@import "/public/css/responsive.css";
</style>
