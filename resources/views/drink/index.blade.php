<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script>Vue.options.delimiters = ['${', '}'];</script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
</head>
<body>
    <v-app id="app" v-if="limit">
        <v-main>
            <v-card elevation="0">
                <v-card-title>
                    <div class="text-h2">Coffee</div>
                </v-card-title>
                <v-card-text>
                    <p>Safe level of caffeine intake per day: <span class="font-weight-bold" v-if="limit">${ limit }mg</span></p>
                    <p>You have already intake: <span class="font-weight-bold" :class="get_intake_class()">${ consumed }mg</span></p>
                    <v-fade-transition>
                        <p class="font-weight-bold" v-if="quota">${ quota }</p>
                    </v-fade-transition>
                    <v-row>
                        <v-col cols="12" md="8" class="d-flex align-center">
                            <v-select v-model="coffee" label="Coffee" :items="drinks" :messages="get_coffee_desc()" item-text="name" return-object @change="calculate_result"></v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="quantity" label="Quantity" :rules="rules.quantity" @input="calculate_result"></v-text-field>
                        </v-col>
                    </v-row>
                    <div class="py-4">
                        <v-btn outlined color="error" @click="reset"><v-icon fab>mdi-restart</v-icon>&nbsp;Reset</v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-main>
    </v-app>
</body>
</html>
<script>
    const list_drink_api = "{{ env('APP_URL').'/api/drink/list' }}";
    const get_limit_api = "{{ env('APP_URL').'/api/drink/limit/get' }}";
    const calculate_api = "{{ env('APP_URL').'/api/drink/calculate' }}";

    var app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            drinks: [],
            limit: 0,
            coffee: null,
            quantity: 1,
            consumed: 0,
            quota: '',
            rules: {
                quantity:[
                    v => !!v || 'Please input the quantity',
                    v => /^\d*$/.test(v) || 'Quantity must be an integer',
                ],
            },
        },
        created: function () {
            this.get_limit();
            this.get_drink();
        },
        methods: {
            async get_drink() {
                let res = await $.get(list_drink_api);
                if (res.status === 'ok') {
                    this.drinks = res.records;
                }
            },
            async get_limit() {
                let res = await $.get(get_limit_api);
                if (res.status === 'ok') {
                    this.limit = res.limit;
                }
            },
            get_intake_class() {
                if (this.consumed === 0) {
                    return '';
                }
                return this.consumed < this.limit ? 'green--text' : 'red--text';
            },
            get_coffee_desc() {
                return this.coffee ? this.coffee.desc : '';
            },
            async calculate_result() {
                if (this.coffee && this.quantity > 0 && !isNaN(this.quantity)) {
                    try {
                        let res = await $.post(calculate_api, {
                            id: this.coffee.id,
                            qty: this.quantity,
                        });
                        if (res.status !== 'ok') {
                            console.log(res);
                        }
                        this.consumed = res.consumed_caffeine;
                        this.quota = res.quota;
                    } catch (e) {
                        console.log(e);
                    }
                } else {
                    return this.reset_result();
                }
            },
            reset_input() {
                this.coffee = null;
                this.quantity = 1;
            },
            reset_result() {
                this.consumed = 0;
                this.quota = '';
            },
            reset() {
                this.reset_input();
                this.reset_result();
            }
        },
    });
</script>
