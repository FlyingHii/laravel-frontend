- build reactjs is all about build custom html element

`ReactDOM.render(
    <App />,            //name of element
  document.getElementById('root')       //where to render
);`

- 1 html fetch from server -> all things handle by reactjs

- `export default App;` -> App is regular JS function but return JSX

- import element to another element by `<Todo text='learn laravel'/>` and input the props to the Todo element => get dynamic content

`<button class="btn" onClick={deleteHandler()}>delete</button>`
- don't call function like above to avoid execute when the component is rendering.
`<button class="btn" onClick={deleteHandler}>delete</button>`