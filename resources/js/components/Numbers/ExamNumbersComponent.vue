<template>
    <div class="container">
      <img :src="src" class="vloume" @click="play()" alt />
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center align-items-center p-4">
                <img style="height: 40px" :src="'/storage/Images/' + count + '.png'" alt="">
                <img style="height: 40px" src="/storage/Images/slash.png" alt="">
                <img style="height: 40px" src="/storage/Images/10.png" alt="">
            </div>
            <div class="col-md-6">
                <div class="col-md-12 d-flex justify-content-center align-items-center p-5">
                    <img class="m-3" style="height: 75px" :src="'/storage/Images/' + firstNum + '.png'" alt="">
                    <img class="m-3" :style="operationStyle()" :src="'/storage/Images/' + operation + '.png'" alt="">
                    <img class="m-3" style="height: 75px" :src="'/storage/Images/' + secondNum + '.png'" alt="">
                    <img class="m-3" style="height: 75px" src="/storage/Images/equal.png" alt="">
                    <div class="result d-flex justify-content-center align-items-center" :class="{divBg : changeColor === true}" id="result" @dragover.prevent @drop="dragFinish(-1, $event)"></div>
                </div>
                <div class="col-md-12 d-flex justify-content-center align-items-center p-4">
                    <img class="m-4" v-for="(result,index) in resultOption" :key="index" @dragover.prevent @dragexit="dragExit(result)" @dragstart="dragStart(result)" @dragenter="dragEnter" @dragleave="dragLeave(result)" @dragend="dragEnd" :draggable="draggable" style="height: 75px;cursor: pointer" :src="'/storage/Images/' + result + '.png'" alt="">
                </div>
                <!-- <img src="/storage/Images/presentations.png" alt=""> -->
                <div class="col-md-12 position-relative d-flex align-items-center" style="justify-content: space-evenly;padding: 30px">
                    <!-- <img class="img-fluid position-absolute" style="width:75px;top: 30px;left: 25px;" src="/storage/Images/door.png" alt=""> -->
                    <button class="button" v-on:click="newQuestion">{{buttonNext}}</button>
                </div>
            </div>
            <div class="col-md-6 position-relative">
                <div style="position: absolute;flex-direction: column;display: flex;justify-content: space-around;align-items: center;top: 15%;left: 40%;width: 53%;">
                    <div v-if="resultFromDrag !== null" class="w-100" style="display: flex;justify-content: space-around;align-items: center;">
                        <img class="m-3" style="height: 80px;" :src="'/storage/Images/' + resultFromDrag + '.png'" alt="">
                        <i class="fa fa-check" v-if="checkResult && result === resultFromDrag" style="font-size: 124px;color: greenyellow;"></i>
                        <i class="fa fa-close" v-if="checkResult && result !== resultFromDrag" style="font-size: 124px;color: red;"></i>
                    </div>
                    <div class="w-100" v-if="checkResult && result !== resultFromDrag" style="display: flex;justify-content: space-around;align-items: center;">
                        <img class="m-3" style="height: 80px;" :src="'/storage/Images/' + result + '.png'" alt="">
                        <i class="fa fa-check" style="font-size: 124px;color: greenyellow;"></i>
                    </div>
                    <div class="pt-3 text-center" style="font-size: 50px;font-weight: bold;">
                        <p class="text-white">{{message}}</p>
                        <img v-if="message == 'Well Done'" class="img-fluid" style="width: 55%;" src="/storage/Images/boy4.png" alt="">
                        <img v-if="message == 'UnLucky'" class="img-fluid" style="width: 35%;" src="/storage/Images/sadboy.png" alt="">
                    </div>
                </div>
                <img class="img-fluid" src="/storage/Images/presentations.png" alt="">
            </div>
            <div class="w-100">
                <a href="/levels" class="d-flex justify-content-center align-items-center w-100"><img class="img-fluid" style="width:75px;" src="/storage/Images/door.png" alt=""></a>
            </div>
        </div>
        <!--  audio -->
        <audio ref="audioElm" src="/storage/Images/happy.mp3"></audio>
        <!--  audio -->
    </div>
</template>
<script>
    export default {
        name: "ExamNumbersComponent",
        data(){
            return {
                questions:[],
                operation:'',
                firstNum:null,
                secondNum:null,
                result:null,
                resultOption:[],
                count:1,
                changeColor:false,
                resultFromDrag:null,
                draggable:true,
                checkResult:false,
                buttonNext:'Next Question',
                showResult:false,
                src: "/storage/Images/close.png",
                message:'',
            }
        },
        methods:{
            play: function(event) {
                var a = this.$refs.audioElm;
                if (a.paused) {
                    a.play();
                    this.src = "/storage/Images/open.png";
                } else {
                    a.pause();
                    this.src = "/storage/Images/close.png";
                }
            },
            randomOperation:function(){
                let minNum = Math.floor(0);
                let maxNum = Math.floor(1);
                let randNum = this.randFun(minNum,maxNum);
                if(randNum === 0){
                    this.operation = 'subtract';
                }else if(randNum === 1) {
                    this.operation = 'plus';
                }
            },
            operationStyle:function(){
                if(this.operation === 'plus'){
                    return 'height: 75px'
                }else {
                    return 'width: 75px'
                }
            },
            randFun:function(minNum,maxNum){
                return Math.floor(Math.random() * (maxNum - minNum + 1)) + minNum;
            },
            pushLastResult: function(min, max) {
                let randResult = this.randFun(min, max);
                // console.log("outside",randResult,this.resultOption);
                while (this.resultOption.includes(randResult) === true) {
                    randResult = this.randFun(min, max);
                    // console.log("inside",randResult,this.resultOption);
                }
                return randResult;
            },
            pushResultOption: function() {
                this.resultOption = [];
                // this.resultOption = Array.from({length: 4}, () => this.pushLastResult(0,10));
                for (let i = 0; i < 3; i++) {
                    let number = this.pushLastResult(0, 10);
                    this.resultOption.push(number);
                }
                console.log(this.resultOption);
                if (this.resultOption.includes(this.result)) {
                    // let number = this.resultOption.indexOf(this.randFun(0,3));
                    // console.log(number);
                    let number = this.pushLastResult(0, 10);
                    // this.resultOption[number] = this.result;
                    this.resultOption.push(number);
                } else {
                    let number = this.pushLastResult(0, 3);
                    this.resultOption.splice(number, 0, this.result);
                }
            },
            randomNumber: function() {
                if (this.operation === "plus") {
                    let randFirstNum = this.randFun(1, 5);
                    let randSecondNum = this.randFun(1, 5);
                    this.firstNum = randFirstNum;
                    this.secondNum = randSecondNum;
                    this.result = this.firstNum + this.secondNum;
                    this.pushResultOption();
                } else if (this.operation === "subtract") {
                    let randFirstNum = this.randFun(0, 10);
                    let randSecondNum = this.randFun(0, 10);
                    if (randFirstNum < randSecondNum) {
                        this.randomNumber();
                    } else {
                        this.firstNum = randFirstNum;
                        this.secondNum = randSecondNum;
                        this.result = this.firstNum - this.secondNum;
                        this.pushResultOption();
                    }
                }
            },
            newQuestion:function () {
                if(this.showResult === true){
                    window.location.href = '/numbersExamResult';
                }
                if(this.count < 10){
                    this.randomOperation();
                    this.randomNumber();
                    this.draggable = true;
                    this.checkResult = false;
                    this.resultFromDrag = null;
                    $('#result').html('');
                    this.count++;
                }
                if(this.count === 10){
                    this.buttonNext = 'Final Result';
                    this.showResult = true;
                }
                this.message = ''
            },
            dragEnter:function () {
                // console.log("dragenter")
            },
            dragLeave:function (num) {
                // this.changeColor = true;
                // console.log("dragLeave",num)
            },
            dragEnd:function () {
                this.changeColor = false;

            },
            dragExit:function(num){
                // console.log("dragExit",num)
            },
            dragFinish:function (index,ev) {
                $('#result').append(`<img class="m-3" style="height: 75px" src="/storage/Images/${this.resultFromDrag}.png" alt="">`);
                this.draggable = false;
                this.checkResult = true;
                if(this.result === this.resultFromDrag){
                    this.message = "Well Done"
                }else{
                    this.message = "UnLucky"
                }
                this.questions.push({
                    firstNum: this.firstNum,
                    secondNum: this.secondNum,
                    operation: this.operation,
                    result: this.result,
                    resultFromDrag: this.resultFromDrag,
                    answer: this.result === this.resultFromDrag,
                    location: window.location.pathname
                });
                localStorage.setItem("finalResult", JSON.stringify(this.questions));
                if(this.count === 10){
                    let levels = JSON.parse(localStorage.getItem('levels'));
                    levels[6].open = true;
                    localStorage.setItem('levels',JSON.stringify(levels))
                }
            },
            dragStart:function (num) {
                this.changeColor = true;
                this.resultFromDrag = num;
            }
        },
        created() {
            this.randomOperation();
            this.randomNumber();
            localStorage.setItem("finalResult", JSON.stringify([]));
        }

    }
</script>
<style scoped>
.button {
    padding: 15px 25px;
    font-size: 24px;
    text-align: center;
    cursor: pointer;
    outline: none;
    color: #fff;
    background-color: #4caf50;
    border: none;
    border-radius: 15px;
    box-shadow: 0 9px #999;
}

.button:hover {
    background-color: #3e8e41;
}

.button:active {
    background-color: #3e8e41;
    box-shadow: 0 5px #666;
    transform: translateY(4px);
}
.result {
    width: 100px;
    height: 100px;
    border: 1px solid gray;
    box-shadow: 0 0 3px 0 gray, inset 0 0 7px 0 gray;
}
.divBg {
    background-color: rgba(85, 169, 56, 0.5);
}
.vloume {
  width: 72px;
  height: 49px;
  position: absolute;
  top: 20%;
  left: 50px;
}
</style>

