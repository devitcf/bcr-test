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
    <v-app id="app">
        <v-main>
            <v-card elevation="0">
                <v-card-title>
                    <div class="text-h2">Coffee</div>
                </v-card-title>
                <v-card-text>
                    <p>Safe level of caffeine intake per day: <span class="font-weight-bold">${ limit }mg</span></p>
                    <p>You have already intake: <span class="font-weight-bold" :class="get_total_class()">${ get_total_caffeine }mg</span></p>
                    <p class="font-weight-bold">${ get_quota }</p>
                    <v-row>
                        <v-col cols="12" md="8" class="d-flex align-center">
                            <v-select v-model="coffee" label="Coffee" :items="drinks" :messages="get_coffee_desc()" item-text="name" return-object></v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field v-model="quantity" label="Quantity" :rules="rules.quantity"></v-text-field>
                        </v-col>
                    </v-row>
                    <div class="py-4">
                        <v-btn outlined color="error" @click="reset"><v-icon fab>mdi-restart-alt</v-icon>&nbsp;Reset</v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-main>
    </v-app>
</body>
</html>
<script>
    const list_drink_api = "{{ env('APP_URL').'api/drink/list' }}";

    var app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            drinks: [],
            limit: 500,
            coffee: null,
            quantity: 1,
            rules: {
                quantity:[
                    v => !!v || 'Please input the quantity',
                    v => /^\d*$/.test(v) || 'Quantity must be an integer',
                ],
            },
        },
        computed: {
            get_total_caffeine() {
                if (this.coffee == null || this.quantity < 1 || isNaN(this.quantity)) {
                    return 0;
                }
                return this.coffee.caffeine * this.quantity;
            },
            get_quota() {
                if (!this.coffee) {
                    return '';
                }
                let remaining_caffeine = this.limit - this.get_total_caffeine;
                let remaining_amount = remaining_caffeine / this.coffee.caffeine;
                remaining_amount = Math.floor(remaining_amount);
                return (remaining_amount <= 0) ? `You cannot consume any more ${this.coffee.name}.` : `You can still consume ${remaining_amount} ${this.coffee.name}.`;
            }
        },
        mounted: async function () {
            let res = await $.get(list_drink_api);
            if (res.status === 'ok') {
                this.drinks = res.records;
            }
        },
        methods: {
            get_total_class() {
                if (this.get_total_caffeine === 0) {
                    return '';
                }
                return this.get_total_caffeine < this.limit ? 'green--text' : 'red--text';
            },
            get_coffee_desc() {
                return this.coffee ? this.coffee.desc : '';
            },
            reset() {
                this.coffee = null;
                this.quantity = 1;
            }
        },
    });
</script>
