<template>
    <div>
        <button class="btn btn-primary mb-2" @click="generateNewQuestions(true)">Generate new questions</button>
        <a class="btn btn-primary mb-2" href="/home">View your report!</a>
        <hr>
        <span v-if="submitted" :class="successCheck">{{submitResponse.message}}</span>
        <div v-if="questions.length == 0">
            Firing up your questions...<img src="https://cdnjs.cloudflare.com/ajax/libs/timelinejs/2.25/css/loading.gif">
        </div>
        <form v-else @submit.prevent="simpleValidate()">
            <div class="form-group" v-for="(question, index) in questions">
                <label>{{question.question}}</label>
                <p v-if="errors[index]">
                    <span class="question-error">*Please select an option.</span>
                </p>
                <div class="form-check" v-for="answer in question.answers">
                    <input class="form-check-input" type="radio" v-bind:name="'question-'+question.id" v-bind:id="'answer-'+answer.id" v-bind:value="answer.id" @change="radioChange(index, answer.id)">
                    <label class="form-check-label" v-bind:for="'answer-'+answer.id">
                        {{answer.answer}}
                    </label>
                </div>
                <hr>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                questions: [],
                errors: [],
                submitted: false,
                submitResponse: {
                    success: '',
                    message: '',
                }
            }
        },

        mounted() {
            this.generateNewQuestions();
        },
        
        computed: {
            /**
             * Used for dynamic class changing for css styling.
             */
            successCheck() {
                return this.submitResponse.success ? 'question-success' : 'question-error';
            }
        },

        methods: {
            /**
             * ajax get function to fetch 3 random questions.
             * reset boolean will be used to determine if error/success messages should be reset.
             *
             * @param boolean reset
             */
            generateNewQuestions(reset) {
                if(reset) {
                    this.submitted = false;
                    this.errors = [];
                }
                this.questions = [];
                axios.get('/fetchQuestions').then((res) => {
                    this.questions = res.data;
                });
            },

            /**
             * Reactive radio change handler. Stores the picked answer for each question.
             *
             * @param integer index
             * @param integer answerId
             */
            radioChange(index, answerId) {
                this.questions[index].picked = answerId;
                this.$set(this.errors, index, false);
            },
            
            /**
             * Form validation and custom form submission using ajax.
             */
            simpleValidate() {
                let submit = true;
                let submitData = [];
                for(let i = 0; i < this.questions.length; i++) {
                    if(this.questions[i].picked == "") {
                        this.$set(this.errors, i, true);
                        submit = false;
                    }
                    else {
                        let data = {
                            question: this.questions[i].id,
                            answer: this.questions[i].picked
                        };
                        submitData.push(data);
                    }
                }

                if(submit) {
                    axios.post('/answerQuestions', submitData).then((res) => {
                        this.submitted = true;
                        this.submitResponse.success = res.data.success;
                        if(res.data.success) {
                            this.submitResponse.message = "Answer Submitted!";
                            this.generateNewQuestions();
                        }
                        else {
                            this.submitResponse.message = res.data.message;
                        }
                    });
                }
            }
        }
    }
</script>