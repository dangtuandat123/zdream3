import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Layout from './components/Layout';
import Home from './pages/Home';
import Studio from './pages/Studio';
import Wallet from './pages/Wallet';

function App() {
  return (
    <Router>
      <Layout>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/studio/:id" element={<Studio />} />
          <Route path="/wallet" element={<Wallet />} />
        </Routes>
      </Layout>
    </Router>
  );
}

export default App;
