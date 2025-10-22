import { useState } from "react";
import "./styles/globals.scss";
import "./App.css";
import { Route, Routes, Navigate } from "react-router";
import Login from "./pages/Login.jsx";
import useAuthStore from "./store/auth.js";
import Dashboard from "./pages/Dashboard.jsx";

function App() {
  const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
  return (
    <>
      <Routes>
        <Route
          path="/"
          element={
            isAuthenticated ? (
              <Navigate to="/dashboard" replace />
            ) : (
              <Navigate to="/login" replace />
            )
          }
        />
        <Route path="/login" element={<Login />} />
        <Route
          path="/dashboard"
          element={
            isAuthenticated ? <Dashboard /> : <Navigate to="/login" replace />
          }
        />
      </Routes>
    </>
  );
}

export default App;
