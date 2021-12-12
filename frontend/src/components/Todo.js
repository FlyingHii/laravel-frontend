// import {} from 'react'

function Todo(props)   {
    let text = props.text;
    let deleteHandler = ($event) => {
        console.log($event);
        text = 'changed!'
    };

    return (
        <div className="card">
            <h2>{text}</h2>
            <div className='actions'>
                <button className="btn" onClick={deleteHandler}>delete</button>
            </div>
        </div>
    );
}

export default Todo;