package main

import (
	"C"
	"io/ioutil"
	"net/http"
)

//export mapTest
var mapTest map[string]int

//string transfer
//export getPhpStringAndReturnString
func getPhpStringAndReturnString(out *C.char) *C.char {
	return C.CString("[GO print] " + C.GoString(out))
}

//GoString transfer
//export getGoStringAndReturnString
func getGoStringAndReturnString(out string) *C.char {
	return C.CString("[GO print] " + out)
}

//int transfer
//export sum
func sum(a C.int, b C.int) C.int {
	return a + b
}

//export httpGet
func httpGet(url string) *C.char {
	resp, err := http.Get(url)
	if err != nil {
		panic(err)
	}

	defer resp.Body.Close()

	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		panic(err)
	}

	return C.CString(string(body))
}

func main() {}
