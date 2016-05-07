from ftplib import FTP
import json
import base64
import random
import binascii



###TODO LIST###
#> Handle downloading & managing folder of jobs
#> Generate job_id
#> Handle managing JSONs on server
#>

#Etching Job
# >File Naming Convention: <job_id>REQ.JSON
#
# >json format:
#{
#    "job_id" : "xxxxxx"
#    "client" : "Last, First"
#    "psswd"  : "password"
#    "email"  : "client@email.com"
#    "image"  : "BASE64_ENCODED_IMAGE"
#}
#

#Etching Progress
# >File Naming Convention: <job_id>PROG.JSON
#
# >json format:
#{
#    "job_id" : "xxxxxx"
#    "client" : "Last, First"
#    "prgrss" : "0"-"100"
#    "ETA"    : "[x/x]: xx:xx:xx"
#    "prgImg" : "BASE64_ENCODED_IMAGE"
#    "coordx" : "x"
#    "coordy" : "y"
#    "voltage": "V volts"
#    "current": "I amps"
#}

# @Returns a handle to the FTP server
def loginToFTP(_domain, _usr, _pss):
    serv = FTP(_domain, _usr, _pss)
    return serv

# @Returns a list of the JSON files names 
def _getJSON_str(serv):
    jList_str = []

    for file in serv.nlst():
        if ".JSON" in file:
            jList_str.append(file)

    return jList_str

# @Returns a list of the JSON objects as strings
def getJSON_str(serv):
    jList = []
    jObjList = []
    
    strlist = _getJSON_str(serv)
    strlist = list(map(lambda x: "RETR " + x, strlist))
    
    for req in strlist:
        tmp = []
        serv.retrbinary(req, tmp.append)
        jList.append("".join(str(tmp)))
    
    return jList

# @Returns a list of the JSON objects (aka a dict)
def getJSON_obj(serv):
    jObjList = []
    
    for j in getJSON_str(serv):
        jObjList.append(json.loads(str(j)))

    return jObjList

# @Returns the base64 encoding of the @file
def encodeImg(file):
    return base64.b64encode(open(file, 'rb').read())

# @Returns the File handle of @dest, a decoded base64-encoded @img 
def decodeImg(img, dest):
    file = open(dest, 'w+b')
    file.write(base64.b64decode(img))
    return file

# @Returns a handle to a JSON Object File
def buildJSON(json_str, file_name):
    file = open(file_name, 'w+')
    file.write(json_str)
    return file 

# @Returns a JSON string/Object
def buildJSON_str(json_dict):
    return json.dumps(json_dict)

# @Returns a dict to be converted into a JSON object
def buildJSON_dict(json_keys, json_items):
    
    if not len(json_keys) == len(json_items):
        return None
    else:
        res = {}
        for i in range(len(json_keys)):
            res[json_keys[i]] = json_items[i]
        return res

# Send File to FTP Server
def sendJSON(json_dict, server):
    file = open(json_dict["job_id"] + "REQ.JSON", 'w+')

    file.write(json.dumps(str(json_dict).replace('\'', '\"')))

    #Send Command
    res = server.sendcmd("put " + json_dict["job_id"])

# @Returns a Either a list for a req or prog JSON
def getJSONFormat(n):
    if n == "req":
        return ["job_id", "client",  "psswd", "email","image"]
    else:
        return  ["job_id", "client", "prgrss" , "ETA", "prgImg", "coordx", "coordy", "voltage", "current"]

# @Returns Job_ID
def generateJobID():
    return random.randint(10*10, 10*11 - 1)
    

#TODO: @Returns a list of Job Request JSON objects
def getJobs(serv):
    return None

#TODO: @Returns a list of Etch Progress JSON objects
def getProgs(serv):
    return None

#TODO: @Returns a boolean whether the update was successful or not
#   >Handles Updating the Progress JSONs, looking for new
#       Request JSONs, and cleaning up obsolete JSONs from the server
#       -If successful update, also returns a list of delete JSONs (if any)
#       -If unsuccessful update, return error message 
def update(serv):
    return None

def main():
    domain = "iot.ohlonemultimedia.net"
    user = "studentIOT@ohlonemultimedia.net"
    psswd =  "IOTohlone99$"


    req = open("981597REQ.JSON",'r+').read()
    
    rj = json.loads(req)
    jf = json.loads(rj)

    print("")
    decodeImg(jf['image'],"img.gif")

    print("YES")

    ftpServ = loginToFTP(domain, user, psswd)
    jobs = getJSON_str(ftpServ)

    img = open("imgt.txt", 'r+')
    
    imgstr = img.read()

    fm = open("img.gif", 'wb+')
    
    #Testing Uploading image
    items = [generateJobID(), "Billy, Bob", "xxxx", "cient@gmail.com", encodeImg("img0.jpg") ]

    jreq = buildJSON_dict(getJSONFormat("req"), items)
    
    file = open("blah.JSON",'w+')
    file.write(str(jreq).replace('\'','\"').replace(",",",\n"))
    file.close()

    jfile = open("blah.JSON",'rb')

    ftpServ.storbinary("STOR " + "blah.JSON",jfile)

    cur = getJSON_obj(ftpServ)


    print("=====END======")


if __name__ == '__main__':
    main()
