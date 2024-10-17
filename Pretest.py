def print_numbers():
    for i in range(1, 101):
        if i % 3 == 0 and i % 5 == 0:
            print("TigaLima")
        elif i % 3 == 0:
            print("Tiga")
        elif i % 5 == 0:
            print("Lima")
        else:
            print(i)

print_numbers()
