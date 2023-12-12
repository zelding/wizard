import $ from 'jquery';

export const Counter = ()=> {
    console.log(
        $("#test_input").val()
    );
};

export const Ping = (p) =>{console.info(p+"asdasd")};

export default Counter;
