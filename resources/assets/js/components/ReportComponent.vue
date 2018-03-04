<template>
    <div>
        <a class="btn btn-primary mb-2" href="/question">Answer more Questions!</a>
        <hr>
        <p>{{displayMessage}}</p>
        <ul class="list-group">
            <li class="list-group-item" v-for="question in questions">
                <p><u>{{question.question}}</u></p>
                You answered:
                <ul class="list-group">
                    <li class="list-group-item" v-for="answer in question.answers">
                        {{answer.answer}} <b>{{answer.count}} time{{answer.count > 1 ? 's' : ''}}</b>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                questions: [],
                displayMessage: 'Your Question Report is displayed below!'
            }
        },

        mounted() {
            /**
             * ajax get function to fetch report.
             */
            axios.get('/fetchReport').then((res) => {
                this.questions = res.data;
                if(this.questions.length < 1) {
                    this.displayMessage = 'You haven\'t answered any questions!';
                }
            });
        },
    }
</script>