import { useState } from "react";
import { useRef } from "react";
import { Link, useSearchParams } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

import * as VKID from '@vkid/sdk';




export default function Login() {


    // VKID.Config.set({
    //     app: 51818778,
    //     redirectUrl: 'http://localhost'
    //   });
      
      
    //   const authButton = document.createElement('button');
    //   authButton.onclick = () => {
    //     VKID.Auth.login(); // После авторизации будет редирект на адрес, указанный в параметре redirect_uri
    //   };
      
    //   document.getElementById('linkvk').appendChild(authButton);

      

    
    const onVk = ()=> {
        VKID.Config.set({
            app: 51818778,
            redirectUrl: 'http://localhost:3000/login'
        });
        VKID.Auth.login(); // После авторизации будет редирект на адрес, указанный в параметре redirect_uri
    }
    

    const emailRef = useRef();
    const passwordRef = useRef();

    const  [errors,setErrors] = useState(null)
    const  {setUser,setToken} = useStateContext()
    const [searchParams, setSearchParams] = useSearchParams();
    const vk = searchParams.get('payload');
    const jsonObj = JSON.parse(vk);
    
    
    console.log(jsonObj);
    const onSubmit = (ev) => {
        ev.preventDefault()
        const payload ={
            email: emailRef.current.value,
            password: passwordRef.current.value,
            
        }
        setErrors(null)
        axiosClient.post('/login',payload)
        .then((data)=>{
            setToken(data.data.data.token)
            setUser(data.data.data.user)
        })
        .catch(err=>{
            const response =err.response;
            if(response && response.status == 422){
                if(response.data.errors){
                    setErrors(response.data.error.errors)
                }else {
                    setErrors({
                        email: [response.data.error.message]
                    })
                }
                
            }
        })
    }

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form className="d-flex flex-column" onSubmit={onSubmit} action="">
                    <h1 className="title">
                        Вход в аккаунт
                    </h1>
                    {errors && <div className="alert">
                        {Object.keys(errors).map(key=>(
                            <p key={key}>{errors[key][0]}</p>
                        ))}
                    </div>
                    }
                    <input ref={emailRef} placeholder="Почта" type="email" />
                    <input ref={passwordRef} placeholder="Пароль" type="password" />
                    <button className="btn btn-primary">Войти</button>
                    <p className="Message text-center">
                        Не зарегестрирован? <Link to="/register">Регистрация</Link>
                    </p>
                    <p className="Message text-center">
                        VKontakte? <a href="#" id="linkvk" className="" onClick={onVk}>Войти</a>
                    </p>
                </form>
            </div>
        </div>
    )
}