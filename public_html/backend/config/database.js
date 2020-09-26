const uri = "mongodb+srv://blockchain:Super!@#4@cluster0.ivkhu.mongodb.net/blockchain?retryWrites=true&w=majority";

mongoose.connect(uri, {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
.then(() => {
  console.log("MongoDB Connected ... ")
})
.catch(err => console.log(err))

module.exports = {
   url : uri
}