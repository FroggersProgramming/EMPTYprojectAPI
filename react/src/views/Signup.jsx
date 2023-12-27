import { useRef, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios-client";
import { useStateContext } from "../contexts/ContextProvider";

export default function Signup() {

    const nameRef = useRef();
    const loginRef = useRef();
    const emailRef = useRef();
    const passwordRef = useRef();
    const passwordConfirmationRef = useRef();

    const  [errors,setErrors] = useState(null)
    const  {setUser,setToken} = useStateContext()

    const onSubmit = (ev) => {
        ev.preventDefault()
        const payload ={
            name: nameRef.current.value,
            login: loginRef.current.value,
            email: emailRef.current.value,
            password: passwordRef.current.value,
            password_confirmation: passwordConfirmationRef.current.value,
        }
        axiosClient.post('/register',payload)
        .then((data)=>{
            setToken(data.data.data.token)
            setUser(data.data.data.user)
        })
        .catch(err=>{
            const response =err.response;
            if(response && response.status == 422){
                setErrors(response.data.error.errors)
            }
        })
    }

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form className="d-flex flex-column" onSubmit={onSubmit} action="">
                    <h1 className="title">
                        Регистрация Аккаунта
                    </h1>
                    {errors && <div className="alert">
                        {Object.keys(errors).map(key=>(
                            <p key={key}>{errors[key][0]}</p>
                        ))}
                    </div>
                    }
                    <input ref={nameRef} placeholder="Имя" type="text" />
                    <input ref={loginRef} placeholder="Логин" type="text" />
                    <input ref={emailRef} placeholder="Почта" type="email" />
                    <input ref={passwordRef} placeholder="Пароль" type="password" />
                    <input ref={passwordConfirmationRef} placeholder="Потвердить пароль" type="password" />
                    <button className="btn btn-primary">Регистрация</button>
                    <p className="Message text-center">
                        Зарегестрирован? <Link to="/login">Войти в аккаунт</Link>
                    </p>
                </form>
            </div>
        </div>
    )
}