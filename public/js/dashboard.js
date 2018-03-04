//Vue.component('question-form', {
//    template: `
//        <form>
//            <div class="form-group" v-for="question in questions">
//                <label for="exampleFormControlSelect2">{{question.question}}</label>
//                <div class="form-check" v-for="answer in question.answers">
//                    <input class="form-check-input" type="radio" v-bind:name="'question-'+question.id" v-bind:id="'answer-'+answer.id" v-bind:value="answer.id">
//                    <label class="form-check-label" v-bind:for="'answer-'+answer.id">
//                        {{answer.answer}}
//                    </label>
//                </div>
//                <hr>
//            </div>
//            <button type="submit" class="btn btn-primary mb-2">Submit</button>
//        </form>
//    `,
//    data: function() {
//        return {
//            questions: [
//                {
//                    id: '1',
//                    question: 'What did you have for breakfast?',
//                    answers: [
//                        {
//                            id: '1',
//                            answer: 'Egg'
//                        },
//                        {
//                            id: '2',
//                            answer: 'Toast'
//                        },
//                        {
//                            id: '3',
//                            answer: 'Cereal'
//                        }
//                    ]
//                },
//                {
//                    id: '2',
//                    question: 'What did you have for lunch?',
//                    answers: [
//                        {
//                            id: '4',
//                            answer: 'Chicken'
//                        },
//                        {
//                            id: '5',
//                            answer: 'Beef'
//                        },
//                        {
//                            id: '6',
//                            answer: 'Turkey'
//                        }
//                    ]
//                },
//                {
//                    id: '3',
//                    question: 'What did you have for dinner?',
//                    answers: [
//                        {
//                            id: '7',
//                            answer: 'Salmon'
//                        },
//                        {
//                            id: '8',
//                            answer: 'Tuna'
//                        },
//                        {
//                            id: '9',
//                            answer: 'Flounder'
//                        }
//                    ]
//                }
//            ]
//        }
//    }
//});
//
//var app = new Vue({
//    el: '#dashboard',
//    
//})

