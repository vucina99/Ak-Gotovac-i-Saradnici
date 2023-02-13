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
                                        <span>DODAJ ZAPOSLENOG</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="w-100 bg-personal-light">
                            <div class="container">
                                <div class="row">
                                    <div class=" col-12 col-lg-12 col-md-12 col-sm-12  pt-3 pb-3">
                                        <vue-confirm-dialog></vue-confirm-dialog>


                                        <div v-if="Object.keys(this.errorData).length > 0"
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
                                            <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; ZAPOSLENI JE USPEŠNO DODAT</span>
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
                                                <label for="ime">IME I PREZIME</label>
                                                <input type="text" v-model="user.ime" name="ime" id="ime"
                                                       class="form-control" placeholder="IME I PREZIME">
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="email">E-MAIL</label>
                                                <input type="text" v-model="user.email" name="email" id="email"
                                                       class="form-control" placeholder="E-MAIL">
                                            </div>

                                            <div class="form-group search-font-size">
                                                <label for="lozinka">LOZINKA</label>
                                                <input type="password" v-model="user.lozinka" name="lozinka" id="lozinka"
                                                       class="form-control" placeholder="LOZINKA">
                                            </div>

                                            <div class="pt-2">
                                                <button class="btn btn-success w-100" @click.prevent="createUser()">
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
                                    <th>IME I PREZIME</th>
                                    <th>EMAIL</th>
                                    <th>POZICIJA</th>
                                    <th>AKCIJA</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(user , index) in users" :key="index">
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.role.name }}</td>
                                    <td @click="deleteUser(user.id , index);"><i class="fa fa-trash text-danger"
                                                                                 aria-hidden="true"></i></td>
                                </tr>
                                <tr v-if="users.length < 1" class="bg-light">
                                    <td colspan="4" class="text-center">
                                        <vue-simple-spinner></vue-simple-spinner>

                                    </td>
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
import Vue from 'vue'
import Spinner from 'vue-simple-spinner'

export default {
    name: "Staff",
    props: [],
    components: {Spinner},
    data() {
        return {
            user: {
                ime: '',
                email: '',
                lozinka: '',
                role: 1,
            },
            errorData: {},
            success: false,
            error: false,
            users: [],
        }
    },
    methods: {
        createUser() {
            axios.post('/admin/create/staff', this.user).then(({data}) => {
                this.success = true
                this.errorData = {}
                this.error = false
                this.users.push(data);
                this.user = {
                    ime: '',
                    email: '',
                    lozinka: '',
                    role: 1,
                }

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
        getUsers() {
            axios.get('/admin/get/users').then(({data}) => {
                this.users = data
                console.log(data);
            })
        },
        deleteUser(id, index) {

            this.$confirm(
                {
                    message: 'DA LI STE SIGURNI DA ŽELITE DA OBRIŠETE KORISNIKA?',
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
                            axios.delete('/admin/delete/user/' + id).then(({data}) => {
                                const filter = this.users.filter((value, key) => {
                                    return key !== index
                                });
                                this.users = filter;
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
        this.getUsers();
    }

}
</script>

<style scoped>

@import "/public/css/style.css";
@import "/public/css/responsive.css";
</style>
