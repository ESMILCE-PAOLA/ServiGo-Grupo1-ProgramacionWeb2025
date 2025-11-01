document.addEventListener('DOMContentLoaded',()=>{
  // Helper para fetch JSON
  window.api = async (url, options={}) => {
    const res = await fetch(url, {headers:{'Content-Type':'application/json'}, credentials:'include', ...options});
    const data = await res.json().catch(()=>({}));
    if(!res.ok) throw new Error(data.error || ('HTTP '+res.status));
    return data;
  };
});