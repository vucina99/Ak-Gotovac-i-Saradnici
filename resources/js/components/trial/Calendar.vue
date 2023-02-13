<template>
    <div class="options-first options-first-lg  ">
        <div class="container">
            <div class="row">
                <div class="col-12"><br><br>
                    <FullCalendar :options='calendarOptions'/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import srLocale from "@fullcalendar/core/locales/sr";

export default {
    name: "Calendar",
    components: {
        FullCalendar, // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                weekends: false,
                events: [],
                dateClick: this.handleDateClick,
                locale: 'sr-ME',
                themeSystem: bootstrap,
                buttonText: {
                    today: "DANAS"
                }
            }
        }
    },
    methods: {
        handleDateClick: function (arg) {
            window.location.href = "/all-trial-from/" + arg.dateStr;

        }
    }
}
</script>

<style scoped>
/*@import 'fullcalendar/dist/fullcalendar.css';*/

</style>
