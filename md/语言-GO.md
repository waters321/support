# Golang

---

0. 注意事项
	1. import 导入
1. 类型
	1. 变量声明 & 初始化 & 赋值
	2. bool 类型
	3. 整型
	4. 浮点类型
	5. 字符串
	6. 字符类型 byte & rune
	7. 复合类型数组：array
	8. 复合类型切片：slice
	9. 复合类型字典：map
	10. 常量
	11. 枚举
	12. 复合类型通道：chan
	13. 复合类型结构体：struct
	14. 复合类型接口：interface
2. 面向对象
3. 顺序编程 & 操作符
4. 反射
5. 序列化
6. strings包
7. PATH包 
8. sync包，锁 & 原子操作
9. flag包


## 0 import 导入




## 1 变量类型

值语义类型

`基本类型：byte,int,bool,float32,float64,string`

`复合类型：array,struct,pointer（指针）`

引用语义类型

`数组切片：指向array的一个区间`

`map,channel,interface`

### 1.1 变量声明 & 初始化 & 赋值
	var a int				// int
	var b string			// string
	var c [10]int			// int数组长度是10
	var d []int				// int切片
	var e struct {			// 结构体
		f int
	}
	var g *int				// int 指针
	var h map[string]int	// map, key为string类型，value为int类型
	var i func(a int) int	// 函数指针

	// struct 初始化
	type User struct  {
		name string
		age int
	}

	a := &User{"hello", 18}	

	// 变量初始化
	var a int				// int默认值0
	var b *int				// 指针默认值为nil
	
	c := make(chan int)		// chan类型只能用make 初始化
	d := make(map[string]int)//map类型只能用make 初始化

	// 变量赋值
	var a int
	a = 10					// 正常赋值

	c, d = d, c				// 交换


### 1.2 bool 类型
	var a bool				// bool类型只接受true或者false
	a = true
	a = false
	a = 1					// error 编译错误
	a = bool(1)				// error 也不支持自动或者强制类型转换 


### 1.3 整型
	var a int8				// -128~127
	var b uint8				// 0~255
	var c int16				// -32768~32767
	var d uint16			// 0～65535
	var e int32				// -2147483648～2147483647
	var f uint32			// 0～4294967295
	var g int64				// -9223372036854775808～9223372036854775807
	var h uint64			// 0～18446744073709551615
	var i int				// 平台相关
	var j uint				// 平台相关
	var k uintptr			// 32平台4字节，64平台8字节

	var a int32				// int32类型
	b := 64					// int 类型
	a = b 					// error 类型 不同不能赋值
	a = int32(b)			// 64

	// 位运算
	x << y					// 左移
	x >> y					// 右移
	x ^ y					// 异或
	x & y					// 与
	x | y					// 或
	^x						// 取反

	124 << 2				// 496
	124 >> 2				// 31
	124 ^ 2					// 126
	124 & 2					// 0
	124 | 2					// 126
	^2						// -3

### 1.4 浮点类型
	var a float32			// 浮点类型采用IEEE-754标准
	var b float64			// 等于C的double类型
	c := 12					// 自动推到为整型
	d := 12.0				// 推到为float64类型

	// 浮点数比较
	// 浮点数不是精确的表达方式，不推荐用==来判断两个浮点数是否相等。推荐使用

	import "math"

	// p 为用户自定义的比较精度，比如0.00001
	func isEqual(f1, f2, p float64) bool {
		return math.Fdim(f1, f2) < p
	}


### 1.5 字符串
	var a string			// 空字符串
	b := "hello"			// 
	b[1]					// 一个字符byte，'e'
	len(b)					// 5个字符
	c := "hello世界"			//
	len(c)					// 11个字符，世界为utf8编码，每个占3个字节
	b + c					// hellohello世界，+符号为字符连接符

	d := "hello,世界"		// 
	for i:=0; i<len(d); i++ {
		fmt.Println(d[i])	// d[i]类型为byte
	}

	for i, ch := range a {
		fmt.Println(i, ch)	// i为字符开始下标，ch为rune类型字符
	}

	// range 的码点
	for i, ru := range "世界" {
		fmt.Printf("%d %x\n", i, ru)	// 输出为unicode码点非utf8码点
	}
	
	// 将world追加到b的末尾
	a := "hello"
	b := a
	b += "world"

	// 下标为3的原始字符就是byte
	fmt.Println(a[3])
	// 从下标为1的位置开始到下标为5-1位置结束的byte原始字符，这里的“哈”字会截掉
	fmt.Println(a[1:5])
	// 从下标为3的字符开始到字符长度-1
	fmt.Println(a[3:])
	// 从首字符开始到下标为3 -1位置
	fmt.Println(a[:3])
	// 全部字符串
	fmt.Println(a[:])
	// 字符串的字节数，这里是14
	fmt.Println(len("hello哈哈哈"))	
	// 字符串的utf8长度，这里是8, 更快的方法 fmt.Println(utf8.RuneCountInString("hello哈哈哈"))
	fmt.Println(len([]rune("hello哈哈哈")))
	// 将字符串转换成unicode码点
	fmt.Println([]rune("hello哈哈哈"))
	// 将rune或者uint32切片转换成字符串，当然里边必须包含的是码点
	var arr = []rune{104, 101, 108, 108, 111, 21704, 21704, 21704}
	// 字符串转换成byte
	fmt.Println([]byte("hello哈哈哈"))
	// 将byte转换成字符串
	var arr2 = []byte{104,101,108,108,111,229,147,136,229,147,136,229,147,136}
	fmt.Println(string(arr2))
	// 整型转字符串
	fmt.Println(strconv.Itoa(123))


	
	
	



### 1.6 字符类型 byte & rune

byte 为 uint8别名

rune 为 4字节。应该是用uint32来保存

### 1.7 复合类型数组：array
数组是值类型，函数传值时会发生复制操作

	[32]byte				// 长度为32的byte数组
	[2]struct{x, y int32}	// 长度为2的struct类型
	[1000]*float			// 长度为1000的指针数组
	[3][5]int				// 二维数组

	var a [5]int = [5]int{1,2,3,4,5} // 1,2,3,4,5
	var b [5]int = [5]int{1}// 1,0,0,0,0
	
### 1.8 复合类型切片：slice
	// 从数组创建切片
	var a [5]int = [5]int{1,2,3,4,5,6,7,8,9,10}
	var b []int = a[:5]		// 1,2,3,4,5
	var c []int = a[1,2]	// 2
	var d []int = a[5:]		// 6,7,8,9,10
	var e []int = a[:]		// 1,2,3,4,5,6,7,8,9,10

	 
`make只能用来创建slice,map,chan。make返回引用。new创建会返回指针`

	// 直接创建切片
	f := make([]int, 5)		// 0,0,0,0,0
	g := make([]int, 5, 10) // 0,0,0,0,0。cap长度为10
	h := []int{1,2,3}		// 1,2,3

	// 元素遍历
	for i:=0; i<len(h); i++ {
		fmt.Println(h[i])	// 1\n, 2\n, 3\n
	}

	for _, val := range h {
		fmt.Println(h[i])	// 1\n, 2\n, 3\n
	}
	
	// 动态增减元素
	a := make([]int, 5)		// 0,0,0,0,0
	b := []int{1,2,3,4,5}	// 1,2,3,4,5

	c := append(a, b...)	// 0,0,0,0,0,1,2,3,4,5
	d := append(a, 1,2,3)	// 0,0,0,0,0,1,2,3
	
`基于数组或者基于切片创建切片，当切片改变时原数组也会改变`

	// 基于切片创建切片
	var a []int = []int{1,2,3,4,5}
	b := a[:3]

	// 内容复制
	var a []int = []int{1,2,3}
	var b []int = []int{4,5,6,7,8,9}

	copy(a, b)				// a为3,4,5
	copy(b, a)				// b为1,2,3,7,8,9

### 1.9 复合类型字典：map

	var a map[string]int	// 
	a = make(map[string]int) // 初始化
	a["hello"] = 1			// 元素赋值
	a["world"] = 2			// 元素赋值
	delete(a, "world")		// 元素删除
	
	i := a["hello"]			// i为1
	i,ok := a["hello"]		// i为1,ok为true
	i,ok := a["notok"]		// i为0,ok为false

	var aa map[int]int = map[int]int {1:1}
	

### 1.10 常量
	const PI float64 = 3.1415926 // 带类型常量
	const zero = 0.0		// 不带类型常量等于字面常量
	const a, b = 1, 2		// 无类型常量
	const (					// 无类型常量
		c = "a"
		d = 123
	)
	const (
		e = iota			// 0
		f = iota			// 1
		g = iota			// 2
	)
	const (
		h = iota			// 0
		i					// 1
		j					// 2
	)
	
### 1.11 枚举
	const (
		Sunday = iota		// 0
		Monday 				// 1
		Tuesday
		Wednesday
		Thursday
		Friday
		Saturday
	)

### 1.12 复合类型通道：chan
	var ch chan int			// 空 int Channel
	ch := make(chan int) 	// int Channel
	ch := make(chan int, 10)// 十个缓冲区的 int Channel
	ch <- 1					// 像ch Channel 发送 1
	<- ch					// 接受一个ch值
	i := <- ch				// 接受一个ch值，赋值给i
	i, err := <- ch			// 接受一个ch值，如果ch关闭则err为非空
	close(ch)				// 关闭chan
	var ch1 chan<- int		// 单向只读chan int 
	var ch2 <-chan int 		// 单向只写chan int
	ch3 := chan<- int(ch)	// 转换ch为只读chan int
	ch4 := <-chan int(ch)	// 转换ch为只写chan int


## 2 流程控制
### 2.1 条件语句
	if true {				// 注意，golang不允许return在if中
		...
	} else {
		...
	}

### 2.2 选择语句

`fallthrough，在switch里执行下一个`
`golang里不需要break退出`

	// i=0， 输出0
	// i=1， 输出1
	// i=2， 输出3 
	// i=3， 输出3
	// i=4， 输出4, 5, 6
	// i=5， 输出4, 5, 6
	// i=6， 输出4, 5, 6
	// i=任意，输出Default
	switch i {
		case 0:
			fmt.Println("0")
		case 1:
			fmt.Println("1")
		case 2:
			fallthrough
		case 3:
			fmt.Println("3")
		case 4,5,6:
			fmt.Println("4,5,6")
		default :
			fmt.Println("Default")
	}

switch 后边无表达式。作用与多个if...else...逻辑作用相同

	switch {
		case 0 <= Num && Num <= 3 :
			fmt.Println("0~3")
		case 4 <= Num && Num <= 6 :
			fmt.Println("4~6")
		case 7 <= Num && Num <= 9 :
			fmt.Println("7~9")
	}

### 2.3 循环语句
`只有for关键字的循环，golang里没有其他循环关键字`

	for i:=0; i<10; i++ {
		...
	}

	// 等于while{}，无限循环
	sum := 0
	for {
		sum++
		if sum>100 {
			break
		}
	}

	// golang不支持i:=0,j:=0这样的逗号赋值
	for i, j := 0, 0; i<10 && j<10; i,j=i+1,j+1 {
		...
	}
	
	// 支持continue，break关键字
	ForHere:
	for i:=0; i<10; i++ {
		if i >= 5 {
			break ForHere
		}
	}
	

### 2.4 跳转语句

	func myFunc() {
		i := 0
		HERE:
		fmt.Println(i)
		i++
		if i < 10 {
			goto HERE
		}
	}

### 2.5 select
	var n int
	for {
		select {
			case n = <- ch
		}
	}

	// select超时
	var n int
	chFor : 
	for {
		select {
			case n = <- ch:
			case <- time.After(time.Second * 3):
				break chFor
		}
	}



## 3 函数

### 3.1 函数定义
	
	// 函数定义
	func test(a int, b int)		// 
	func test(a,b int)			// 同上
	func test(a int, b int) (ret int, err error)	// 带返回值函数

	// 匿名函数定义
	fun := func(a int, b int) int 

### 3.2 不定参数

	func myfunc(args ...int) {
		for _, arg := range args {
			fmt.Println(arg)
		}
	}

	myfunc(1,2,3)
	myfunc(1,2,3,4,5,6)
	
	var a []int = []int{10,20,30,40}
	myfunc(a...)	// 等于myfunc(10,20,30,40)

	// 不定参数，interface类型
	func myfunc2(args ...interface{}) {
		for _,arg := range args{
			switch arg.(type) {
				case int :
					fmt.Printf("This is Int: %d", arg)
				case string :
					fmt.Printf("THis is String:%s\n", arg)
			}
		}
	}
	
	myfunc2(10)		//  10
	myfunc2(10, "hello") // 10,hello

	
	// 多返回值
	func myfunc3() (int,int) {
		return 1,2
	}

### 3.3 Defer

`Defer 遵循后进先出原则`
	
	defer func() {
		fmt.Println("a");
	}()
	
### 3.4 错误类型

	// 原生错误
	err := errors.New("first error")

	// 自定义错误类型
	type errorTest struct {
		s string
	}
	func (e *errorTest)Error() string {
		return e.s
	}
	
	func myfunc() (int,error) {
		err := &errorTest{"myfunc error"}
		return 10,err
	}
	
	func main() {
		_,err := myfunc()
		fmt.Println(err)
	}


### 3.5 panic() & recover()

当函数执行panic函数时，正常函数执行流程立即终止。函数中defer关键字正常执行。之后返回调用函数，并导致逐层执行panic。直至goroutine执行函数终止。错误信息将被报告，包括panic调用时传入的参数。
	
func panic(interface{})

从错误流程中恢复过来，使用defer关键字执行

func recover() interface{}

	func reco() {
		if r := recover(); r != nil {
			fmt.Printf("Recover %s", r)
		}
	}

	func main() {
	
		defer reco()

		panic("hoho")

		fmt.Println("hello")
	}
	// 最终输出 Recover hoho
	

## 4 面向对象
### 4.1 对象声明与定义
	
	// 定义类型
	type Header map[string][]string
	type Integer

	// 定义结构体
	type User struct {
		Name string
		Age int
	}

	func (this *User) getAge() (int) {
		return this.Age
	}

	func (this *User) setAge(age int) {
		this.Age = age
	}

	// 初始化结构体
	user := new(User)
	user := &User{}
	user := &User{"hello", 10}
	user := &User{Name:"world", Age:10}
	users:= []User{{Name:"1", Age:1}, {Name:"2", Age:2}}
	

### 4.2 匿名组合 & 嵌入类型

	// 定义结构体
	type Person struct {
		Name string
		Age int
		Level int
	}
	
	func (this *Person) Fight() {
		fmt.Println("Person.Fight()")
	}
	
	type Hero struct {
		Person
	}
	
	func (this *Hero) Fight() {
		fmt.Println("Hero Fight")
		this.Person.Fight()
	}
	
	type Soldier struct {
		*Person
	}
	
	func (this *Soldier) Fight() {
		fmt.Println("Soldier Fight")
		this.Person.Fight()
	}
	
	// 指针类型
	func main() {
		h := &Hero{Person{"person", 10, 100}}
		h.Fight()					
		h.Person.Fight()
		
		s := &Soldier{&Person{"person", 10, 100}}
		s.Fight()
	}

	// 输出
	// Hero Fight
	// Person.Fight()
	// Person.Fight()
	// Soldier Fight
	// Person.Fight()


### 4.3 接口 & interface
	
	type Integer int
	
	func (a Integer) Less(b Integer) bool {
		return a < b
	}
	
	func (a *Integer) Add(b Integer) {
		*a += b
	}
	
	type LessAdder interface {
		Less(b Integer) bool
		Add(b Integer)
	}

	func main() {
	
	
		var i Integer
		var ier LessAdder = &i
	
		i = 10
		i.Add(10)
		
		
		
		fmt.Println(ier.Less(20))
		// 输出 false

	}

### 4.4 接口查询

### 4.5 类型查询



	// 接口声明与调用
	type Integer int  
	
	func (this Integer) Less(b Integer) bool {
		return this < b
	}
	
	func (this *Integer) Add(b Integer) {
		*this += b
	}
	
	func (this Integer) Show() {
		fmt.Println(this)
	}
	
	type IntegerInterface interface {
		Less(b Integer) (bool)
		Add(b Integer)
		Show()
	}
	
	func main() {
	
		var a Integer
		a.Add(Integer(1))
		fmt.Println(a)		// 1
		
		var b Integer
		b = 2
		
		var bInterface IntegerInterface
		bInterface = &b
		bInterface.Add(1)
		bInterface.Show()	// 3
	}

### 5.2 接口查询



## 5 网络编程
## 6 reflect

### 6.1 

	type T struct {
		A int
		B string
	}
	
	func main() {
	
		t := T{23, "skidoo"}
		s := reflect.ValueOf(&t).Elem()
		fmt.Println(s)
	
		typeOfT := s.Type()
		for i := 0; i < s.NumField(); i++ {
			f := s.Field(i)
			fmt.Printf("%d: %s %s = %v\n", i,
			typeOfT.Field(i).Name, f.Type(), f.Interface())
		}
	}


## 序列化

### json

	type Road struct {
		Name   string
		Number int
	}

	b, err := json.Marshal(Road{})
	if err != nil {
		//log.Fatal(err)
	}

	fmt.Println(string(b))



	var jsonBlob = []byte(`[
		{"Name": "Platypus", "Order": "Monotremata"},
		{"Name": "Quoll",    "Order": "Dasyuromorphia"}
	]`)
	type Animal struct {
		Name  string
		Order string
	}
	var animals []Animal
	err = json.Unmarshal(jsonBlob, &animals)
	if err != nil {
		fmt.Println("error:", err)
	}
	fmt.Printf("%+v", animals)

	// 输出
	// {"Name":"","Number":0}
	// [{Name:Platypus Order:Monotremata} {Name:Quoll Order:Dasyuromorphia}]



## 7 sync
## 8 CGO
## 9 flag包







