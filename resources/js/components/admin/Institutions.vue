<template>
    <div>
        <div class="options-first options-first-lg  ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="choose-type">
                            <div class="container">
                                <div class="row">
                                    <div
                                        class="type-div-size type-div-size-back  bg-blue text-light pt-2 pb-2 d-flex align-items-center justify-content-center border-light-full">
                                        <span>DODAJ INSTITUCIJU</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="w-100 bg-personal-light">
                            <div class="container">
                                <div class="row">
                                    <div class=" col-12 col-lg-12 col-md-12 col-sm-12  pt-3 pb-3">
                                        <vue-confirm-dialog></vue-confirm-dialog>

                                        <div v-if="Object.keys(errorData).length > 0"
                                             class="alert error-danger alert-danger alert-dismissible fade show"
                                             role="alert">

                                            <div v-for="(error, index) in errorData" :key="index">
                                                 <span v-for="(errorChildern, key) in error" :key="key">
                                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp;  {{
                                                         errorChildern
                                                     }}
                                                 </span>
                                            </div>

                                        </div>
                                        <div v-if="success"
                                             class="alert error-danger alert-success alert-dismissible fade show"
                                             role="alert">
                                            <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; INSTITUCIJA JE USPEŠNO DODATA</span>
                                            <button @click.prevent="success = false" type="button" class="close"  >
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div v-if="error"
                                             class="alert error-danger alert-danger alert-dismissible fade show"
                                             role="alert">
                                            <span> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp; DOŠLO JE DO GREŠKE, PROVERITE PODATKE ZA UNOS</span>
                                            <button @click.prevent="error = false" type="button" class="close"  >
                                                <span>&times;</span>
                                            </button>
                                        </div>


                                        <form action="">


                                            <div class="form-group search-font-size">
                                                <label for="name">NAZIV</label>
                                                <input type="text" name="name" v-model="institution.ime" id="name"
                                                       class="form-control" placeholder="NAZIV">
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="type">VRSTA</label>
                                                <v-select
                                                    :options="type"
                                                    id="type"
                                                    name="vrsta"
                                                    label="name"
                                                    placeholder="VRSTA"
                                                    v-model="institution.vrsta">
                                                </v-select>
                                            </div>
                                            <div class="pt-2">
                                                <button class="btn btn-success w-100" @click.prevent="addInstitution()">
                                                    DODAJ <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
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
                                    <th>NAZIV</th>
                                    <th>VRSTA</th>
                                    <th>AKCIJA</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(institution, index) in allInstitutions" :key="index">
                                    <td>{{ institution.name }}</td>
                                    <td>{{ institution.institution_type.name }}</td>
                                    <td @click.prevent="changeActivation(institution,index)">

                                        <i class="fa fa-circle text-success" v-if="institution.activation  "
                                           aria-hidden="true"></i>
                                        <i class="fa fa-circle text-danger" v-if="!institution.activation  "
                                           aria-hidden="true"></i>
                                    </td>
                                </tr>
                                <tr v-if="allInstitutions == null" class="bg-light">
                                    <td colspan="3" class="text-center">
                                        <vue-simple-spinner></vue-simple-spinner>

                                    </td>
                                </tr>
                                <tr v-if="allInstitutions  != null && allInstitutions.length < 1" class="bg-light">
                                    <td colspan="3" class="text-center">
                                        <span>NEMA PODATAKA ZA PRIKAZ</span>

                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <br>
                            <nav aria-label="Page navigation example" v-if="paginateCount > 1 ">
                                <ul class="pagination justify-content-center">
                                    <li v-if=" page !== 0" :class="[ page == 0 ? 'disabled' : '' ,  'page-item'  ]"
                                        @click.prevent="getInstitutions(page - 1)">
                                        <a class="page-link one" href="#" tabindex="-1"><i class="fa fa-chevron-left"
                                                                                           aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li v-for="index in paginateCount" :key="index"
                                        @click.prevent="getInstitutions(index-1)"
                                        :class="[page == index-1 ? 'active' : '' ,'page-item']"><a
                                        class="page-link number" href="#">{{ index }}</a></li>
                                    <li v-if=" page !== paginateCount - 1 "
                                        :class="[ page == paginateCount - 1 ? 'disabled' : '' ,  'page-item'  ]"
                                        @click.prevent="getInstitutions(page + 1)">
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


export default {
    name: "Institutions",
    props: [],
    components: {
        'v-select': vSelect,
    },

    data() {
        return {
            type: [],
            allInstitutions: null,
            institution: {'ime': '', 'vrsta': ''},
            errorData: {},
            success: false,
            error: false,
            paginateCount: 0,
            page: 0,
        }
    },
    methods: {
        getType() {
            axios.get('/admin/get/type').then(({data}) => {
                this.type = data
            });
        },
        getInstitutions(page = 0) {
            if (page >= 0 && page <= this.paginateCount)
                this.page = page
            axios.get('/admin/get/institutions/' + page).then(({data}) => {
                this.allInstitutions = data.data
                this.paginateCount = data.count

            });
        },
        addInstitution() {
            axios.post('/admin/create/institution', this.institution).then(({data}) => {
                this.success = true
                this.errorData = {}
                this.error = false
                this.allInstitutions.push(data);
                this.institution = {'ime': '', 'vrsta': ''}
            }).catch((error) => {
                if (error.response.status == 400) {
                    this.errorData = error.response.data.original
                    this.success = false
                    this.error = false
                } else {
                    this.error = true
                    this.success = false
                }
            });
        },
        changeActivation(value, index) {

            this.$confirm(
                {
                    title: value.name,
                    message: 'DA LI STE SIGURNI DA ŽELITE DA IZMENITE AKTIVNOST ?',
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
                            axios.patch('/admin/update/activation/intitution/' + value.id).then(({data}) => {
                                this.allInstitutions = this.allInstitutions.map((x, indexMap) => (index === indexMap) ? data : x)
                            }).catch((error) => {
                                alert('POKUŠAJTE POSLE, DOŠLO JE DO GREŠKE')
                            });

                        }
                    }
                }
            )

        }
    },
    created() {
        this.getType();
        this.getInstitutions();
    }
}
</script>

<style scoped>
@import "vue-select/dist/vue-select.css";
@import "/public/css/style.css";
@import "/public/css/responsive.css";
</style>
