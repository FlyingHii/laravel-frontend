import Todo from './components/Todo'
import Modal from './components/Modal'

function App() {
  return (
      <div>
          <h1>Todos</h1>
          <Todo text='learn react'/>
          <Todo text='learn laravel'/>
          <Modal/>
      </div>
  );
}

export default App;
