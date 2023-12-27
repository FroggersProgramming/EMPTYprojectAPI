import { useRef, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios-client";
import { useStateContext } from "../contexts/ContextProvider";

export default function AdvertisementsForm() {

    const titleRef = useRef();
    const descriptionRef = useRef();
    const locationRef = useRef();

    const passwordRef = useRef();
    const passwordConfirmationRef = useRef();

    const  [errors,setErrors] = useState(null)
    const  {setUser,setToken} = useStateContext()

    const onSubmit = (ev) => {
        ev.preventDefault()
        const payload ={
            title: titleRef.current.value,
            description: descriptionRef.current.value,
            location: locationRef.current.value,
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
        <div className="card animated fadeInDown">
            <div className="form">
                <form className="" onSubmit={onSubmit} action="">
                    <h3 className="title mb-2">
                        Новое объявление
                    </h3>
                    {errors && <div className="alert">
                        {Object.keys(errors).map(key=>(
                            <p key={key}>{errors[key][0]}</p>
                        ))}
                    </div>
                    }
                    <input ref={titleRef} placeholder="Заголовок" class="form-control" type="text" />
                    <textarea ref={descriptionRef} placeholder="Описание объявления" class="form-control mb-3" rows="3" />
                    <input ref={locationRef} placeholder="Место" class="form-control mb-3" type="text" />
                    <button className="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    )
}