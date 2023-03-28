import{o as d,c as n,a as e,F as b,r as f,b as i,t as c,w as x,d as p,v as m}from"./app-bc7374f8.js";import{_ as g}from"./_plugin-vue_export-helper-c27b6911.js";const _={setup(){const a=ref(),o=useRouter(),l=reactive({email:"",password:""});return{form:l,errors:a,handleLogin:async()=>{try{const s=await axios.post("/api/auth/login",l);s.status===200&&s.data&&s.data.token&&(localStorage.setItem("APP_USER_TOKEN",s.data.token),await o.push("home"))}catch(s){s&&s.response.data&&s.response.data.errors?a.value=Object.values(s.response.data.errors):a.value=s.response.data.message||""}}}}},h={class:"mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg"},w={class:"bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"},y=e("h1",{class:"text-gray-600 py-5 font-bold text-3xl"}," Login ",-1),v={key:1,class:"list-disc text-red-400"},k={class:"mb-4"},L=e("label",{class:"block text-grey-darker text-sm font-bold mb-2",for:"username"}," Email Address ",-1),E={class:"mb-4"},S=e("label",{class:"block text-grey-darker text-sm font-bold mb-2",for:"password"}," Password ",-1),V=e("div",{class:"flex items-center justify-between"},[e("button",{class:"bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded",type:"submit"}," Sign In ")],-1);function j(a,o,l,t,s,B){return d(),n("div",h,[e("div",w,[y,typeof t.errors=="object"?(d(!0),n(b,{key:0},f(t.errors,(r,u)=>(d(),n("ul",{class:"list-disc text-red-400",key:u},[e("li",null,c(r[0]),1)]))),128)):i("",!0),typeof t.errors=="string"?(d(),n("p",v,c(t.errors),1)):i("",!0),e("form",{method:"post",onSubmit:o[2]||(o[2]=x((...r)=>t.handleLogin&&t.handleLogin(...r),["prevent"]))},[e("div",k,[L,p(e("input",{class:"shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker",id:"username",type:"text","onUpdate:modelValue":o[0]||(o[0]=r=>t.form.email=r),required:""},null,512),[[m,t.form.email]])]),e("div",E,[S,p(e("input",{class:"shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3",id:"password",type:"password","onUpdate:modelValue":o[1]||(o[1]=r=>t.form.password=r),required:""},null,512),[[m,t.form.password]])]),V],32)])])}const N=g(_,[["render",j]]);export{N as default};