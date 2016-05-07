def parseGCODE(_fin, _fout):
    
    
    fin = open('g.gcode','r+')#open(Fin, 'r+')
    fout= open('o.gcode','w+')#open(_fout,'w+')

  
    gcode = list(map(lambda x: x.strip(),(fin.read()).split()))
    gcode = list(map(lambda x: x.replace('\n',''), gcode))
    
    _max = 190.0000
    max = 1
    
    #Get the Max of the x and y
    for item in gcode:
        if 'X' in item or 'Y' in item:
            if float(item[1:]) > max:
                max = float(item[1:])


    print(max)
    
    #Parse Through to commands to scale down x,y,i,j
    #   and add new lines to G & M commands
    #   and 
    tmp = list(map((lambda item: " " + item[0] + str(round(float(item[1:])*(_max/max),4)) if 'X' in item or 'Y' in item or 'J' in item or 'I' in item else ("\n"+item) if ('G' in  item or 'M' in item) else " "+item if ('P' in item or 'F' in item or 'S' in item) else item),gcode))
    
    tmp[0] = tmp[0][1:] + "\nG28 Z\nG28 Y\nG28 X\nG1 Z5 F100\nG1 X10 Y10 F1000\n"

    fout.write("".join(tmp))

    fin.close()
    fout.close()
            
   

if __name__ == '__main__':
    
     parseGCODE(None, None)

    

